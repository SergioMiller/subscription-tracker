<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Entities\Subscription;
use App\Entities\User;
use App\Entities\UserSubscription;
use App\Enums\Subscription\SubscriptionStatusEnum;
use App\Interfaces\Repositories\UserSubscriptionRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

final class UserSubscriptionRepository extends AbstractRepository implements UserSubscriptionRepositoryInterface
{
    public function entityClassName(): string
    {
        return UserSubscription::class;
    }

    public function paginate(User $user, array $filter = []): LengthAwarePaginator
    {
        return $this->paginator(
            callback: fn (Builder $query) => $query
                ->select(['user_subscriptions.*'])
                ->where('user_id', $user->getKey())
                ->with(['subscription', 'currency'])
                ->when(
                    value: !empty($filter['type']),
                    callback: fn (Builder $query) => $query->whereHas(
                        relation: 'subscription',
                        callback: fn (Builder $query) => $query->where('type', $filter['type'])
                    )
                )
                ->when(
                    value: !empty($filter['price_min']) || !empty($filter['price_max']),
                    callback: function (Builder $query) use ($filter, $user) {
                        $min = $filter['price_min'] ? ($filter['price_min'] * 100) : null;
                        $max = $filter['price_max'] ? ($filter['price_max'] * 100) : null;

                        $column = match ($filter['price']) {
                            'base' => 'price',
                            default => 'converted',
                        };

                        if ('converted' === $column) {
                            $query->leftJoin('currencies', 'currencies.id', '=', 'user_subscriptions.currency_id')
                                ->leftJoin('exchange_rates', function (JoinClause $leftJoin) use ($user) {
                                    $leftJoin->on('currencies.id', '=', 'exchange_rates.from_currency_id');
                                    $leftJoin->on('exchange_rates.to_currency_id', '=', DB::raw($user->default_currency_id));
                                });
                            $column = DB::raw('user_subscriptions.price * exchange_rates.rate');
                        }

                        if ($min && $max) {
                            $query->whereBetween($column, [$min, $max]);
                        } elseif ($min) {
                            $query->where($column, '>=', $min);
                        } elseif ($max) {
                            $query->where($column, '<=', $max);
                        }
                    }
                )
                ->when(
                    value: !empty($filter['month']),
                    callback: function (Builder $query) use ($filter) {
                        [$year, $month] = explode('-', $filter['month']);

                        $query->whereMonth('finish_at', $month);
                        $query->whereYear('finish_at', $year);
                    }
                )
                ->latest('id'),
            paginationDto: new PaginationDto($filter)
        );
    }

    public function activeSubscriptions(User $user, array $with = []): Collection
    {
        return $this->getEntity()
            ->newQuery()
            ->with($with)
            ->where('user_id', $user->getKey())
            ->where('user_subscriptions.status', SubscriptionStatusEnum::ACTIVE)
            ->get();
    }

    public function getBySubscription(User $user, Subscription $subscription): UserSubscription|null
    {
        return $this->getEntity()
            ->newQuery()
            ->where('user_id', $user->getKey())
            ->where('subscription_id', $subscription->getKey())
            ->first();
    }
}
