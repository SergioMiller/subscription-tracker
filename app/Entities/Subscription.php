<?php
declare(strict_types=1);

namespace App\Entities;

use App\Enums\Subscription\SubscriptionTypeEnum;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property int|null $price
 * @property int|null $base_price
 * @property int|null $currency_id
 * @property SubscriptionTypeEnum $type
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property-read  Currency $currency
 */
class Subscription extends Model
{
    protected $table = 'subscriptions';

    protected $casts = [
        'type' => SubscriptionTypeEnum::class,
    ];

    public function currency(): BelongsTo
    {
        return $this->belongsTo(Currency::class);
    }
}
