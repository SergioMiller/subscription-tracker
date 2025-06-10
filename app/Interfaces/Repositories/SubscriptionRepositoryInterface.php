<?php
declare(strict_types=1);

namespace App\Interfaces\Repositories;

use App\Entities\Subscription;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * @method Subscription save(Subscription $entity)
 * @method Subscription|null getByKey(int $id)
 */
interface SubscriptionRepositoryInterface extends RepositoryInterface
{
    public function paginate(array $filter): LengthAwarePaginator;
}
