<?php
declare(strict_types=1);

namespace App\Enums\Subscription;

enum SubscriptionTypeEnum: string
{
    case DAILY = 'daily';
    case WEEKLY = 'weekly';
    case MONTHLY = 'monthly';
    case YEARLY = 'yearly';
}
