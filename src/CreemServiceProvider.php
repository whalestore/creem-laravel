<?php

namespace Creem;

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
        }

        // Register webhook routes if configured
        $this->registerWebhookRoutes();
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
}
