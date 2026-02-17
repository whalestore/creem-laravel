<?php

namespace Creem\View\Components;

use Creem\Creem;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Paywall extends Component
{
    public array $products = [];
    public string $userId;
    public ?string $currentPlan;
    public string $checkoutEndpoint;
    public ?string $successUrl;
    public ?string $cancelUrl;
    public string $theme;
    public bool $showFeatures;

    public function __construct(
        string $userId,
        ?array $products = null,
        ?string $currentPlan = null,
        ?string $successUrl = null,
        ?string $cancelUrl = null,
        string $theme = 'default',
        bool $showFeatures = true
    ) {
        $this->userId = $userId;
        $this->currentPlan = $currentPlan;
        $this->successUrl = $successUrl;
        $this->cancelUrl = $cancelUrl;
        $this->theme = $theme;
        $this->showFeatures = $showFeatures;

        // If products are provided directly, use them
        if ($products !== null) {
            $this->products = $products;
        } else {
            // Otherwise, fetch from Creem API
            $this->products = $this->fetchProducts();
        }

        $this->checkoutEndpoint = route('creem.checkout');
    }

    protected function fetchProducts(): array
    {
        try {
            $creem = app(Creem::class);
            $response = $creem->products()->list(['limit' => 10]);
            return $response['items'] ?? [];
        } catch (\Exception $e) {
            return [];
        }
    }

    public function render(): View
    {
        return view('creem::components.paywall');
    }
}
