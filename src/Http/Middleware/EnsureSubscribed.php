<?php

namespace Creem\Http\Middleware;

use Closure;
use Creem\Creem;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureSubscribed
{
    public function __construct(
        protected Creem $creem
    ) {}

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string|null  $plan  Optional specific plan to check for
     */
    public function handle(Request $request, Closure $next, ?string $plan = null): Response
    {
        $user = $request->user();

        if (!$user) {
            return $this->unauthorized($request);
        }

        // Get user identifier - check for custom method or use default
        $userId = $this->getUserIdentifier($user);

        if (!$userId) {
            return $this->unauthorized($request);
        }

        // Check subscription status
        if (!$this->hasActiveSubscription($userId, $plan)) {
            return $this->subscriptionRequired($request);
        }

        return $next($request);
    }

    /**
     * Get the user identifier for Creem
     */
    protected function getUserIdentifier($user): ?string
    {
        // Check if user has a custom Creem identifier method
        if (method_exists($user, 'creemId')) {
            return $user->creemId();
        }

        // Check for creem_customer_id attribute
        if (!empty($user->creem_customer_id)) {
            return $user->creem_customer_id;
        }

        // Fallback to user ID
        return (string) $user->getKey();
    }

    /**
     * Check if user has an active subscription
     */
    protected function hasActiveSubscription(string $userId, ?string $plan = null): bool
    {
        try {
            // Use the HTTP client to list subscriptions for the customer
            $response = $this->creem->getClient()->get('/v1/subscriptions', [
                'customer_id' => $userId,
                'status' => 'active',
            ]);

            $subscriptions = $response['items'] ?? [];

            if (empty($subscriptions)) {
                return false;
            }

            // If a specific plan is required, check for it
            if ($plan !== null) {
                foreach ($subscriptions as $subscription) {
                    if (($subscription['product_id'] ?? '') === $plan) {
                        return true;
                    }
                }
                return false;
            }

            return true;
        } catch (\Exception $e) {
            // Log error but don't block the request if API fails
            \Illuminate\Support\Facades\Log::warning('Creem subscription check failed', [
                'user_id' => $userId,
                'error' => $e->getMessage(),
            ]);

            // Configurable behavior on API failure
            return config('creem.subscription.allow_on_error', false);
        }
    }

    /**
     * Handle unauthorized request
     */
    protected function unauthorized(Request $request): Response
    {
        if ($request->expectsJson()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $redirectUrl = config('creem.subscription.login_redirect', '/login');

        return redirect()->guest($redirectUrl);
    }

    /**
     * Handle subscription required
     */
    protected function subscriptionRequired(Request $request): Response
    {
        if ($request->expectsJson()) {
            return response()->json([
                'error' => 'Subscription required',
                'message' => 'An active subscription is required to access this resource.',
            ], 403);
        }

        $redirectUrl = config('creem.subscription.redirect', '/subscribe');

        return redirect($redirectUrl)
            ->with('error', 'An active subscription is required to access this feature.');
    }
}
