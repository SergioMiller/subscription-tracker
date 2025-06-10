<?php
declare(strict_types=1);

namespace App\Interfaces\Repositories;

use App\Entities\Currency;
use App\Entities\ExchangeRate;

interface ExchangeRateRepositoryInterface
{
    public function getRate(int $fromId, int $toId): ExchangeRate|null;
}
