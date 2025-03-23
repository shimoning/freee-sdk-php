<?php

namespace Shimoning\FreeeSdk\Laravel\Facade;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \Shimoning\FreeeSdk\Webhook\Domains\Common\Entities\Event handle(string|array<string, string|int|array<string, string|int>> $payload, bool $verify = true)
 * @see \Shimoning\FreeeSdk\Webhook\Handler
 */
class FreeeWebhook extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    public static function getFacadeAccessor(): string
    {
        return 'freee-webhook';
    }
}
