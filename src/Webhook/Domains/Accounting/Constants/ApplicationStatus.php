<?php

namespace Shimoning\FreeeSdk\Webhook\Domains\Accounting\Constants;

enum ApplicationStatus: string
{
    case DRAFT       = 'draft';
    case IN_PROGRESS = 'in_progress';
    case APPROVED    = 'approved';
    case REJECTED    = 'rejected';
    case FEEDBACK    = 'feedback';
}
