# Creem Laravel SDK

A Laravel SDK for integrating with the [Creem](https://creem.io) payment platform. This package provides a simple and elegant way to interact with the Creem API in your Laravel applications.

## Requirements

- PHP 8.1+
- Laravel 10.0+

## Installation

Install the package via Composer:

```bash
composer require creem/laravel-sdk
```

## Configuration

Publish the configuration file:

```bash
php artisan vendor:publish --tag=creem-config
```

Add your API credentials to your `.env` file:

```env
CREEM_API_KEY=your_api_key_here
CREEM_ENVIRONMENT=production  # or 'sandbox' for testing
CREEM_WEBHOOK_SECRET=your_webhook_secret
```

## Quick Start

### Using the Facade

```php
use Creem\Facades\Creem;

// Create a checkout session
$checkout = Creem::getFacadeRoot()->checkouts->create(
    new CreateCheckoutRequest(
        productId: 'prod_xxx',
        successUrl: 'https://example.com/success',
        cancelUrl: 'https://example.com/cancel',
    )
);

// Redirect to checkout
return redirect($checkout->checkoutUrl);
```

### Using Dependency Injection

```php
use Creem\Creem;

class PaymentController extends Controller
{
    public function __construct(private Creem $creem) {}

    public function createCheckout()
    {
        $checkout = $this->creem->checkouts->create(
            new CreateCheckoutRequest(
                productId: 'prod_xxx',
                successUrl: url('/success'),
            )
        );

        return redirect($checkout->checkoutUrl);
    }
}
```

## Available Resources

### Products

```php
// Get a product
$product = $creem->products->get('prod_xxx');

// Create a product
$product = $creem->products->create(new CreateProductRequest(
    name: 'Premium Plan',
    price: 2999,
    currency: ProductCurrency::USD,
    billingType: ProductBillingType::Recurring,
));

// Search products
$result = $creem->products->search(pageNumber: 1, pageSize: 10);
```

### Customers

```php
// Retrieve a customer
$customer = $creem->customers->retrieve(customerId: 'cust_xxx');
$customer = $creem->customers->retrieve(email: 'user@example.com');

// List customers
$result = $creem->customers->list(pageNumber: 1, pageSize: 20);

// Generate billing portal link
$links = $creem->customers->generateBillingLinks(
    new CreateCustomerPortalLinkRequest(
        customerId: 'cust_xxx',
        returnUrl: 'https://example.com/account',
    )
);
```

### Subscriptions

```php
// Get a subscription
$subscription = $creem->subscriptions->get('sub_xxx');

// Cancel a subscription
$subscription = $creem->subscriptions->cancel('sub_xxx',
    new CancelSubscriptionRequest(cancelAtPeriodEnd: true)
);

// Upgrade a subscription
$subscription = $creem->subscriptions->upgrade('sub_xxx',
    new UpgradeSubscriptionRequest(newProductId: 'prod_yyy')
);

// Pause/Resume
$creem->subscriptions->pause('sub_xxx');
$creem->subscriptions->resume('sub_xxx');
```

### Licenses

```php
// Activate a license
$license = $creem->licenses->activate(new ActivateLicenseRequest(
    key: 'XXXX-XXXX-XXXX-XXXX',
    instanceName: 'My Device',
));

// Validate a license
$license = $creem->licenses->validate(new ValidateLicenseRequest(
    key: 'XXXX-XXXX-XXXX-XXXX',
));

// Deactivate a license
$license = $creem->licenses->deactivate(new DeactivateLicenseRequest(
    key: 'XXXX-XXXX-XXXX-XXXX',
    instanceId: 'inst_xxx',
));
```

### Discounts

```php
// Get a discount
$discount = $creem->discounts->get(discountId: 'disc_xxx');
$discount = $creem->discounts->get(discountCode: 'SUMMER20');

// Create a discount
$discount = $creem->discounts->create(new CreateDiscountRequest(
    name: 'Summer Sale',
    code: 'SUMMER20',
    type: DiscountType::Percentage,
    percentage: 20.0,
));
```

## Webhooks

The SDK automatically registers a webhook route at `/webhooks/creem` (configurable).

### Listening to Events

```php
// In your EventServiceProvider
use Creem\Webhooks\Events\CheckoutCompleted;
use Creem\Webhooks\Events\SubscriptionActive;

protected $listen = [
    CheckoutCompleted::class => [
        HandleCheckoutCompleted::class,
    ],
    SubscriptionActive::class => [
        HandleSubscriptionActive::class,
    ],
];
```

### Creating an Event Listener

```php
use Creem\Webhooks\Events\CheckoutCompleted;

class HandleCheckoutCompleted
{
    public function handle(CheckoutCompleted $event)
    {
        $checkoutData = $event->webhookEvent->getData();
        // Handle the checkout...
    }
}
```

## Error Handling

The SDK throws specific exceptions for different error types:

```php
use Creem\Exceptions\AuthenticationException;
use Creem\Exceptions\NotFoundException;
use Creem\Exceptions\RateLimitException;
use Creem\Exceptions\ValidationException;

try {
    $product = $creem->products->get('prod_xxx');
} catch (NotFoundException $e) {
    // Product not found (404)
} catch (AuthenticationException $e) {
    // Invalid API key (401)
} catch (RateLimitException $e) {
    // Too many requests (429)
} catch (ValidationException $e) {
    // Validation error (400)
}
```

## Testing

Run the test suite:

```bash
./vendor/bin/pest
```

## License

MIT License. See [LICENSE](LICENSE) for details.
