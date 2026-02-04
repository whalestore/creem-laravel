# Creem Laravel SDK

用于集成 [Creem](https://creem.io) 支付平台的 Laravel SDK。本扩展包提供了简洁优雅的方式在 Laravel 应用中调用 Creem API。

## 系统要求

- PHP 8.1+
- Laravel 10.0+

## 安装

通过 Composer 安装：

```bash
composer require creem/laravel-sdk
```

## 配置

发布配置文件：

```bash
php artisan vendor:publish --tag=creem-config
```

在 `.env` 文件中添加 API 凭证：

```env
CREEM_API_KEY=your_api_key_here
CREEM_ENVIRONMENT=production  # 或 'sandbox' 用于测试
CREEM_WEBHOOK_SECRET=your_webhook_secret
```

## 快速开始

### 使用 Facade

```php
use Creem\Facades\Creem;

// 创建结账会话
$checkout = Creem::getFacadeRoot()->checkouts->create(
    new CreateCheckoutRequest(
        productId: 'prod_xxx',
        successUrl: 'https://example.com/success',
        cancelUrl: 'https://example.com/cancel',
    )
);

// 重定向到结账页面
return redirect($checkout->checkoutUrl);
```

### 使用依赖注入

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

## 可用资源

### 产品 (Products)

```php
// 获取产品
$product = $creem->products->get('prod_xxx');

// 创建产品
$product = $creem->products->create(new CreateProductRequest(
    name: '高级套餐',
    price: 2999,
    currency: ProductCurrency::USD,
    billingType: ProductBillingType::Recurring,
));

// 搜索产品
$result = $creem->products->search(pageNumber: 1, pageSize: 10);
```

### 客户 (Customers)

```php
// 检索客户
$customer = $creem->customers->retrieve(customerId: 'cust_xxx');
$customer = $creem->customers->retrieve(email: 'user@example.com');

// 列出客户
$result = $creem->customers->list(pageNumber: 1, pageSize: 20);

// 生成账单门户链接
$links = $creem->customers->generateBillingLinks(
    new CreateCustomerPortalLinkRequest(
        customerId: 'cust_xxx',
        returnUrl: 'https://example.com/account',
    )
);
```

### 订阅 (Subscriptions)

```php
// 获取订阅
$subscription = $creem->subscriptions->get('sub_xxx');

// 取消订阅
$subscription = $creem->subscriptions->cancel('sub_xxx',
    new CancelSubscriptionRequest(cancelAtPeriodEnd: true)
);

// 升级订阅
$subscription = $creem->subscriptions->upgrade('sub_xxx',
    new UpgradeSubscriptionRequest(newProductId: 'prod_yyy')
);

// 暂停/恢复
$creem->subscriptions->pause('sub_xxx');
$creem->subscriptions->resume('sub_xxx');
```

### 许可证 (Licenses)

```php
// 激活许可证
$license = $creem->licenses->activate(new ActivateLicenseRequest(
    key: 'XXXX-XXXX-XXXX-XXXX',
    instanceName: '我的设备',
));

// 验证许可证
$license = $creem->licenses->validate(new ValidateLicenseRequest(
    key: 'XXXX-XXXX-XXXX-XXXX',
));

// 停用许可证
$license = $creem->licenses->deactivate(new DeactivateLicenseRequest(
    key: 'XXXX-XXXX-XXXX-XXXX',
    instanceId: 'inst_xxx',
));
```

### 折扣 (Discounts)

```php
// 获取折扣
$discount = $creem->discounts->get(discountId: 'disc_xxx');
$discount = $creem->discounts->get(discountCode: 'SUMMER20');

// 创建折扣
$discount = $creem->discounts->create(new CreateDiscountRequest(
    name: '夏季促销',
    code: 'SUMMER20',
    type: DiscountType::Percentage,
    percentage: 20.0,
));
```

## Webhooks

SDK 会自动注册 Webhook 路由到 `/webhooks/creem`（可配置）。

### 监听事件

```php
// 在 EventServiceProvider 中
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

### 创建事件监听器

```php
use Creem\Webhooks\Events\CheckoutCompleted;

class HandleCheckoutCompleted
{
    public function handle(CheckoutCompleted $event)
    {
        $checkoutData = $event->webhookEvent->getData();
        // 处理结账...
    }
}
```

## 错误处理

SDK 会为不同错误类型抛出特定异常：

```php
use Creem\Exceptions\AuthenticationException;
use Creem\Exceptions\NotFoundException;
use Creem\Exceptions\RateLimitException;
use Creem\Exceptions\ValidationException;

try {
    $product = $creem->products->get('prod_xxx');
} catch (NotFoundException $e) {
    // 产品未找到 (404)
} catch (AuthenticationException $e) {
    // API Key 无效 (401)
} catch (RateLimitException $e) {
    // 请求过于频繁 (429)
} catch (ValidationException $e) {
    // 验证错误 (400)
}
```

## 测试

运行测试套件：

```bash
./vendor/bin/pest
```

## 许可证

MIT 许可证。详见 [LICENSE](LICENSE)。
