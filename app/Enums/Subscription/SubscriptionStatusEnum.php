<?php
declare(strict_types=1);

namespace App\Enums\Subscription;

use App\Helpers\EnumHelper;

enum SubscriptionStatusEnum: string
{
    use EnumHelper;

    case ACTIVE = 'active';
    case DUE = 'due';
    case UNSUBSCRIBED = 'unsubscribed';
}
