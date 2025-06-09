<?php
declare(strict_types=1);

namespace App\Interfaces\Repositories;

use App\Entities\Currency;

/**
 * @method Currency save(Currency $entity)
 * @method Currency|null getByKey(int $id)
 */
interface CurrencyRepositoryInterface extends RepositoryInterface
{
}
