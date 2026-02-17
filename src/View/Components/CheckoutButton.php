<?php

namespace Creem\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class CheckoutButton extends Component
{
    public string $productId;
    public string $userId;
    public ?string $label;
    public ?string $successUrl;
    public ?string $cancelUrl;
    public ?string $discountCode;
    public string $variant;
    public string $size;
    public bool $disabled;
    public string $checkoutEndpoint;

    public function __construct(
        string $productId,
        string $userId,
        ?string $label = null,
        ?string $successUrl = null,
        ?string $cancelUrl = null,
        ?string $discountCode = null,
        string $variant = 'primary',
        string $size = 'md',
        bool $disabled = false
    ) {
        $this->productId = $productId;
        $this->userId = $userId;
        $this->label = $label ?? 'Subscribe';
        $this->successUrl = $successUrl;
        $this->cancelUrl = $cancelUrl;
        $this->discountCode = $discountCode;
        $this->variant = $variant;
        $this->size = $size;
        $this->disabled = $disabled;
        $this->checkoutEndpoint = route('creem.checkout');
    }

    public function render(): View
    {
        return view('creem::components.checkout-button');
    }
}
