<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Entities\Subscription;
use App\Interfaces\Repositories\SubscriptionRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;

final class SubscriptionRepository extends AbstractRepository implements SubscriptionRepositoryInterface
{
    public function entityClassName(): string
    {
        return Subscription::class;
    }

    public function paginate(array $filter): LengthAwarePaginator
    {
        return $this->paginator(
            callback: fn (Builder $query) => $query->with('currency')->latest('id'),
            paginationDto: new PaginationDto($filter)
        );
    }
}
