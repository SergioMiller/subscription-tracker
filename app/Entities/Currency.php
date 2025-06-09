<?php
declare(strict_types=1);

namespace App\Entities;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property string $code
 * @property string $symbol
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Currency extends Model
{
    public const string USD = 'USD';

    public const string EUR = 'EUR';

    public const string UAH = 'UAH';

    protected $table = 'currencies';
}
