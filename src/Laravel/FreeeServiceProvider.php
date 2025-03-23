<?php

namespace Shimoning\FreeeSdk\Laravel;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Log;
use Shimoning\FreeeSdk\Webhook\Handler;

class FreeeServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/config/freee.php' => config_path('freee.php'),
        ], 'config');
    }

    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/config/freee.php',
            'freee',
        );

        $this->app->bind('freee-webhook', function () {
            $logging = config('freee.webhook.logging', false);
            $logger  = \is_string($logging)
                ? Log::channel($logging)
                : ($logging ? Log::getLogger() : null);
            return new Handler(
                config('freee.webhook.verification_token'),
                $logger,
            );
        });
    }
}
