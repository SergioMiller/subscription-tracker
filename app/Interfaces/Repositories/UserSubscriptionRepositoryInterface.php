<?php
declare(strict_types=1);

namespace App\Interfaces\Repositories;

use App\Entities\Subscription;
use App\Entities\User;
use App\Entities\UserSubscription;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

/**
 * @method UserSubscription save(UserSubscription $entity)
 * @method UserSubscription|null getByKey(int $id)
 */
interface UserSubscriptionRepositoryInterface extends RepositoryInterface
{
    public function paginate(array $filter): LengthAwarePaginator;

    public function activeSubscriptions(User $user): Collection;

    public function getBySubscription(User $user, Subscription $subscription): UserSubscription|null;
}
