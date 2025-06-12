<?php
declare(strict_types=1);

namespace App\Entities;

use App\Enums\Subscription\SubscriptionStatusEnum;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $user_id
 * @property int $subscription_id
 * @property int $currency_id
 * @property int $price
 * @property int $base_price
 * @property SubscriptionStatusEnum $status
 * @property Carbon|string $start_at
 * @property Carbon|string $finish_at
 * @property Carbon|string $created_at
 * @property Carbon|string $updated_at
 * @property-read User $user
 * @property-read Subscription $subscription
 * @property-read Currency $currency
 * @property int $user_price
 * @property Currency $user_currency
 */
final class UserSubscription extends Model
{
    protected $table = 'user_subscriptions';

    protected $casts = [
        'status' => SubscriptionStatusEnum::class,
        'start_at' => 'datetime',
        'finish_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function subscription(): BelongsTo
    {
        return $this->belongsTo(Subscription::class);
    }

    public function currency(): BelongsTo
    {
        return $this->belongsTo(Currency::class);
    }

    public function getPrice(): float
    {
        return round($this->price / 100, 2);
    }

    public function setUserPrice(float $userPrice): self
    {
        $this->user_price = $userPrice;

        return $this;
    }

    public function setUserCurrency(Currency $userCurrency): self
    {
        $this->user_currency = $userCurrency;

        return $this;
    }

    public function getUserPrice(): float
    {
        return round($this->user_price / 100, 2);
    }

    public function getUserCurrency(): Currency
    {
        return $this->user_currency;
    }
}
