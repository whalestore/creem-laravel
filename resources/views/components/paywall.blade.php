@props([
    'products' => [],
    'userId' => '',
    'currentPlan' => null,
    'checkoutEndpoint' => '',
    'successUrl' => null,
    'cancelUrl' => null,
    'theme' => 'default',
    'showFeatures' => true,
])

<div class="creem-paywall creem-paywall--{{ $theme }}">
    <div class="creem-paywall__grid">
        @forelse($products as $product)
            <div class="creem-paywall__card {{ $currentPlan === ($product['id'] ?? '') ? 'creem-paywall__card--current' : '' }}">
                @if(!empty($product['badge']))
                    <div class="creem-paywall__badge">{{ $product['badge'] }}</div>
                @endif

                <div class="creem-paywall__header">
                    <h3 class="creem-paywall__name">{{ $product['name'] ?? 'Product' }}</h3>
                    @if(!empty($product['description']))
                        <p class="creem-paywall__description">{{ $product['description'] }}</p>
                    @endif
                </div>

                <div class="creem-paywall__price">
                    <span class="creem-paywall__amount">
                        {{ $product['currency'] ?? '$' }}{{ number_format(($product['price'] ?? 0) / 100, 2) }}
                    </span>
                    @if(!empty($product['billing_period']))
                        <span class="creem-paywall__period">/{{ $product['billing_period'] }}</span>
                    @endif
                </div>

                @if($showFeatures && !empty($product['features']))
                    <ul class="creem-paywall__features">
                        @foreach($product['features'] as $feature)
                            <li class="creem-paywall__feature">
                                <svg class="creem-paywall__check" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                                {{ is_array($feature) ? ($feature['name'] ?? $feature['text'] ?? '') : $feature }}
                            </li>
                        @endforeach
                    </ul>
                @endif

                <div class="creem-paywall__action">
                    @if($currentPlan === ($product['id'] ?? ''))
                        <button class="creem-paywall__button creem-paywall__button--current" disabled>
                            Current Plan
                        </button>
                    @else
                        <form action="{{ $checkoutEndpoint }}" method="POST">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product['id'] ?? '' }}">
                            <input type="hidden" name="user_id" value="{{ $userId }}">
                            @if($successUrl)
                                <input type="hidden" name="success_url" value="{{ $successUrl }}">
                            @endif
                            @if($cancelUrl)
                                <input type="hidden" name="cancel_url" value="{{ $cancelUrl }}">
                            @endif
                            <button type="submit" class="creem-paywall__button creem-paywall__button--primary">
                                {{ $product['button_text'] ?? 'Get Started' }}
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        @empty
            <div class="creem-paywall__empty">
                <p>No products available</p>
            </div>
        @endforelse
    </div>
</div>

<style>
.creem-paywall {
    --creem-primary: #6366f1;
    --creem-primary-hover: #4f46e5;
    --creem-text: #1f2937;
    --creem-text-muted: #6b7280;
    --creem-border: #e5e7eb;
    --creem-bg: #ffffff;
    --creem-bg-muted: #f9fafb;
    --creem-success: #10b981;
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, sans-serif;
}

.creem-paywall__grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 1.5rem;
    max-width: 1200px;
    margin: 0 auto;
}

.creem-paywall__card {
    background: var(--creem-bg);
    border: 1px solid var(--creem-border);
    border-radius: 1rem;
    padding: 1.5rem;
    position: relative;
    display: flex;
    flex-direction: column;
}

.creem-paywall__card--current {
    border-color: var(--creem-primary);
    box-shadow: 0 0 0 1px var(--creem-primary);
}

.creem-paywall__badge {
    position: absolute;
    top: -0.75rem;
    left: 50%;
    transform: translateX(-50%);
    background: var(--creem-primary);
    color: white;
    padding: 0.25rem 0.75rem;
    border-radius: 9999px;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
}

.creem-paywall__header {
    margin-bottom: 1rem;
}

.creem-paywall__name {
    font-size: 1.25rem;
    font-weight: 600;
    color: var(--creem-text);
    margin: 0 0 0.5rem;
}

.creem-paywall__description {
    font-size: 0.875rem;
    color: var(--creem-text-muted);
    margin: 0;
}

.creem-paywall__price {
    margin-bottom: 1.5rem;
}

.creem-paywall__amount {
    font-size: 2.5rem;
    font-weight: 700;
    color: var(--creem-text);
}

.creem-paywall__period {
    font-size: 1rem;
    color: var(--creem-text-muted);
}

.creem-paywall__features {
    list-style: none;
    padding: 0;
    margin: 0 0 1.5rem;
    flex-grow: 1;
}

.creem-paywall__feature {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 0;
    font-size: 0.875rem;
    color: var(--creem-text);
}

.creem-paywall__check {
    width: 1.25rem;
    height: 1.25rem;
    color: var(--creem-success);
    flex-shrink: 0;
}

.creem-paywall__action {
    margin-top: auto;
}

.creem-paywall__button {
    width: 100%;
    padding: 0.75rem 1.5rem;
    font-size: 1rem;
    font-weight: 600;
    border-radius: 0.5rem;
    cursor: pointer;
    transition: all 0.2s;
    border: none;
}

.creem-paywall__button--primary {
    background: var(--creem-primary);
    color: white;
}

.creem-paywall__button--primary:hover {
    background: var(--creem-primary-hover);
}

.creem-paywall__button--current {
    background: var(--creem-bg-muted);
    color: var(--creem-text-muted);
    cursor: default;
}

.creem-paywall__empty {
    text-align: center;
    padding: 3rem;
    color: var(--creem-text-muted);
}
</style>
