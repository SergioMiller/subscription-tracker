<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Entities\Subscription;
use App\Entities\User;
use App\Entities\UserSubscription;
use App\Enums\Subscription\SubscriptionStatusEnum;
use App\Interfaces\Repositories\UserSubscriptionRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

class UserSubscriptionRepository extends AbstractRepository implements UserSubscriptionRepositoryInterface
{
    public function entityClassName(): string
    {
        return UserSubscription::class;
    }

    public function paginate(User $user, array $filter = []): LengthAwarePaginator
    {
        return $this->paginator(
            callback: fn (Builder $query) => $query
                ->where('user_id', $user->getKey())
                ->with([
                    'subscription',
                    'currency' => function (BelongsTo $query) use ($user) {
                        $query->with([
                            'exchangeRates' => function (HasMany $query) use ($user) {
                                $query->where('to_currency_id', $user->default_currency_id);
                            }
                        ]);
                    }
                ])
                ->latest('id'),
            paginationDto: new PaginationDto($filter)
        );
    }

    public function activeSubscriptions(User $user): Collection
    {
        $now = Carbon::now()->toDateTimeString();

        return $this->getEntity()
            ->newQuery()
            ->where('user_id', $user->getKey())
            ->where('user_subscriptions.status', SubscriptionStatusEnum::ACTIVE)
            ->where('user_subscriptions.start_at', '<', $now)
            ->where('user_subscriptions.finish_at', '>', $now)
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
