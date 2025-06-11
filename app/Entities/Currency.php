<?php
declare(strict_types=1);

namespace App\Entities;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

/**
 * @property int $id
 * @property string $name
 * @property string $code
 * @property string $symbol
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Collection|ExchangeRate[] $exchangeRates
 */
class Currency extends Model
{
    public const int DEFAULT_CURRENCY_ID = 1;

    public const string USD = 'USD';

    public const string EUR = 'EUR';

    public const string UAH = 'UAH';

    protected $table = 'currencies';

    public function exchangeRates(): HasMany
    {
        return $this->hasMany(ExchangeRate::class, 'from_currency_id', 'id');
    }
}
