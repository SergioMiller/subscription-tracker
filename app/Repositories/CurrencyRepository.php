<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Entities\Currency;
use App\Interfaces\Repositories\CurrencyRepositoryInterface;

class CurrencyRepository extends AbstractRepository implements CurrencyRepositoryInterface
{
    public function entityClassName(): string
    {
        return Currency::class;
    }
}
