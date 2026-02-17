<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Creem API Key
    |--------------------------------------------------------------------------
    |
    | Your Creem API key for authenticating requests. This key will be sent
    | in the 'x-api-key' header with every API request.
    |
    */
    'api_key' => env('CREEM_API_KEY'),

    /*
    |--------------------------------------------------------------------------
    | Environment
    |--------------------------------------------------------------------------
    |
    | The Creem environment to use. Set to 'production' for live transactions
    | or 'test' for sandbox testing.
    |
    | Supported: "production", "test"
    |
    */
    'environment' => env('CREEM_ENVIRONMENT', 'production'),

    /*
    |--------------------------------------------------------------------------
    | API Base URLs
    |--------------------------------------------------------------------------
    |
    | The base URLs for the Creem API. You typically don't need to change these
    | unless you're using a custom proxy or mock server.
    |
    */
    'base_url' => [
        'production' => env('CREEM_PRODUCTION_URL', 'https://api.creem.io'),
        'test' => env('CREEM_TEST_URL', 'https://test-api.creem.io'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Request Timeout
    |--------------------------------------------------------------------------
    |
    | The timeout in seconds for API requests. Set to 0 for no timeout.
    |
    */
    'timeout' => env('CREEM_TIMEOUT', 30),

    /*
    |--------------------------------------------------------------------------
    | Retry Configuration
    |--------------------------------------------------------------------------
    |
    | Configure how the SDK should retry failed requests.
    |
    */
    'retry' => [
        // Retry strategy: 'none' or 'backoff'
        'strategy' => env('CREEM_RETRY_STRATEGY', 'backoff'),

        // Initial retry interval in milliseconds
        'initial_interval' => env('CREEM_RETRY_INITIAL_INTERVAL', 500),

        // Maximum retry interval in milliseconds
        'max_interval' => env('CREEM_RETRY_MAX_INTERVAL', 60000),

        // Exponential backoff multiplier
        'exponent' => env('CREEM_RETRY_EXPONENT', 1.5),

        // Maximum total retry time in milliseconds
        'max_elapsed_time' => env('CREEM_RETRY_MAX_ELAPSED_TIME', 3600000),

        // HTTP status codes that should trigger a retry
        'retry_codes' => ['429', '500', '502', '503', '504'],

        // Whether to retry on connection errors
        'retry_connection_errors' => env('CREEM_RETRY_CONNECTION_ERRORS', true),
    ],

    /*
    |--------------------------------------------------------------------------
    | Webhook Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration for handling Creem webhooks.
    |
    */
    'webhook' => [
        // The secret used to verify webhook signatures
        'secret' => env('CREEM_WEBHOOK_SECRET'),

        // The route path for the webhook endpoint
        'path' => env('CREEM_WEBHOOK_PATH', '/webhooks/creem'),

        // Middleware to apply to the webhook route
        'middleware' => [],
    ],

    /*
    |--------------------------------------------------------------------------
    | Debug Mode
    |--------------------------------------------------------------------------
    |
    | Enable debug mode to log all API requests and responses.
    |
    */
    'debug' => env('CREEM_DEBUG', false),

    /*
    |--------------------------------------------------------------------------
    | Subscription Middleware Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration for the EnsureSubscribed middleware.
    |
    */
    'subscription' => [
        // Where to redirect users who need to subscribe
        'redirect' => env('CREEM_SUBSCRIPTION_REDIRECT', '/subscribe'),

        // Where to redirect unauthenticated users
        'login_redirect' => env('CREEM_LOGIN_REDIRECT', '/login'),

        // Allow access if subscription check fails (API error, etc.)
        'allow_on_error' => env('CREEM_ALLOW_ON_ERROR', false),
    ],

    /*
    |--------------------------------------------------------------------------
    | Checkout Route Path
    |--------------------------------------------------------------------------
    |
    | The route path for the checkout form handler.
    |
    */
    'checkout_path' => env('CREEM_CHECKOUT_PATH', '/creem/checkout'),
];
