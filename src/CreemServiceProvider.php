<?php

namespace Creem;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class CreemServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/creem.php', 'creem');

        $this->app->singleton(Creem::class, function ($app) {
            return new Creem($app['config']['creem']);
        });

        $this->app->alias(Creem::class, 'creem');
    }

    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/creem.php' => config_path('creem.php'),
            ], 'creem-config');

            $this->publishes([
                __DIR__ . '/../resources/views' => resource_path('views/vendor/creem'),
            ], 'creem-views');
        }

        // Register views
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'creem');

        // Register Blade components
        $this->registerBladeComponents();

        // Register middleware alias
        $this->registerMiddleware();

        // Register webhook routes if configured
        $this->registerWebhookRoutes();

        // Register checkout route
        $this->registerCheckoutRoute();
    }

    protected function registerBladeComponents(): void
    {
        Blade::component('creem-paywall', \Creem\View\Components\Paywall::class);
        Blade::component('creem-checkout-button', \Creem\View\Components\CheckoutButton::class);
    }

    protected function registerMiddleware(): void
    {
        $router = $this->app['router'];

        // Register middleware alias for Laravel 11+
        if (method_exists($router, 'aliasMiddleware')) {
            $router->aliasMiddleware('subscribed', \Creem\Http\Middleware\EnsureSubscribed::class);
            $router->aliasMiddleware('creem.subscribed', \Creem\Http\Middleware\EnsureSubscribed::class);
        }
    }

    protected function registerWebhookRoutes(): void
    {
        $config = $this->app['config']['creem.webhook'] ?? [];
        $path = $config['path'] ?? '/webhooks/creem';

        if (!empty($config['secret'])) {
            $this->app['router']->post($path, [
                'uses' => \Creem\Webhooks\WebhookController::class . '@handle',
                'middleware' => $config['middleware'] ?? [],
            ])->name('creem.webhook');
        }
    }

    protected function registerCheckoutRoute(): void
    {
        $config = $this->app['config']['creem'] ?? [];
        $path = $config['checkout_path'] ?? '/creem/checkout';

        $this->app['router']->post($path, function (\Illuminate\Http\Request $request) {
            $creem = app(Creem::class);

            $checkoutData = [
                'product_id' => $request->input('product_id'),
                'success_url' => $request->input('success_url', url()->previous()),
                'request_id' => $request->input('request_id'),
                'metadata' => [
                    'user_id' => $request->input('user_id'),
                ],
            ];

            if ($request->filled('discount_code')) {
                $checkoutData['discount_code'] = $request->input('discount_code');
            }

            $checkout = $creem->checkouts()->create($checkoutData);

            return redirect($checkout->checkout_url);
        })->middleware(['web'])->name('creem.checkout');
    }
}
