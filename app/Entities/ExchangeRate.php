<?php
declare(strict_types=1);

namespace App\Entities;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $from_currency_id
 * @property int $to_currency_id
 * @property float $rate
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
final class ExchangeRate extends Model
{
    protected $table = 'exchange_rates';

    protected $casts = [
        'rate' => 'float',
    ];
}
