<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Entities\Subscription;
use App\Interfaces\Repositories\SubscriptionRepositoryInterface;

class SubscriptionRepository extends AbstractRepository implements SubscriptionRepositoryInterface
{
    public function entityClassName(): string
    {
        return Subscription::class;
    }
}
