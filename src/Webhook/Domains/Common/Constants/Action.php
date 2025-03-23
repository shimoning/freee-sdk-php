<?php

namespace Shimoning\FreeeSdk\Webhook\Domains\Common\Constants;

enum Action: string
{
    case CREATED   = 'created';
    case UPDATED   = 'updated';
    case DESTROYED = 'destroyed';
}
