@props([
    'productId' => '',
    'userId' => '',
    'label' => 'Subscribe',
    'successUrl' => null,
    'cancelUrl' => null,
    'discountCode' => null,
    'variant' => 'primary',
    'size' => 'md',
    'disabled' => false,
    'checkoutEndpoint' => '',
])

<form action="{{ $checkoutEndpoint }}" method="POST" class="creem-checkout-form">
    @csrf
    <input type="hidden" name="product_id" value="{{ $productId }}">
    <input type="hidden" name="user_id" value="{{ $userId }}">
    @if($successUrl)
        <input type="hidden" name="success_url" value="{{ $successUrl }}">
    @endif
    @if($cancelUrl)
        <input type="hidden" name="cancel_url" value="{{ $cancelUrl }}">
    @endif
    @if($discountCode)
        <input type="hidden" name="discount_code" value="{{ $discountCode }}">
    @endif

    <button
        type="submit"
        class="creem-checkout-button creem-checkout-button--{{ $variant }} creem-checkout-button--{{ $size }}"
        {{ $disabled ? 'disabled' : '' }}
        {{ $attributes }}
    >
        {{ $label }}
    </button>
</form>

<style>
.creem-checkout-form {
    display: inline-block;
}

.creem-checkout-button {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    border-radius: 0.5rem;
    cursor: pointer;
    transition: all 0.2s ease;
    border: none;
    text-decoration: none;
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, sans-serif;
}

.creem-checkout-button:disabled {
    opacity: 0.5;
    cursor: not-allowed;
}

/* Variants */
.creem-checkout-button--primary {
    background: #6366f1;
    color: white;
}

.creem-checkout-button--primary:hover:not(:disabled) {
    background: #4f46e5;
}

.creem-checkout-button--secondary {
    background: #f3f4f6;
    color: #374151;
}

.creem-checkout-button--secondary:hover:not(:disabled) {
    background: #e5e7eb;
}

.creem-checkout-button--outline {
    background: transparent;
    color: #6366f1;
    border: 2px solid #6366f1;
}

.creem-checkout-button--outline:hover:not(:disabled) {
    background: #6366f1;
    color: white;
}

/* Sizes */
.creem-checkout-button--sm {
    padding: 0.5rem 1rem;
    font-size: 0.875rem;
}

.creem-checkout-button--md {
    padding: 0.75rem 1.5rem;
    font-size: 1rem;
}

.creem-checkout-button--lg {
    padding: 1rem 2rem;
    font-size: 1.125rem;
}

.creem-checkout-button--full {
    width: 100%;
    padding: 0.75rem 1.5rem;
    font-size: 1rem;
}
</style>
