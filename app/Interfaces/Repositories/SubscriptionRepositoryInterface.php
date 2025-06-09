<?php
declare(strict_types=1);

namespace App\Interfaces\Repositories;

use App\Entities\Subscription;

/**
 * @method Subscription save(Subscription $entity)
 * @method Subscription|null getByKey(int $id)
 */
interface SubscriptionRepositoryInterface extends RepositoryInterface
{
}
