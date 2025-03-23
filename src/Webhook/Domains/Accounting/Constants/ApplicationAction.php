<?php

namespace Shimoning\FreeeSdk\Webhook\Domains\Accounting\Constants;

enum ApplicationAction: string
{
    case DRAFT          = 'draft';
    case APPLY          = 'apply';
    case APPROVE        = 'approve';
    case FORCE_APPROVE  = 'force_approve';
    case CANCEL         = 'cancel';
    case REJECT         = 'reject';
    case FEEDBACK       = 'feedback';
    case FORCE_FEEDBACK = 'force_feedback';
}
