<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Entities\ExchangeRate;
use App\Interfaces\Repositories\ExchangeRateRepositoryInterface;

final class ExchangeRateRepository implements ExchangeRateRepositoryInterface
{
    public function entityClassName(): string
    {
        return ExchangeRate::class;
    }

    protected function getEntity(): ExchangeRate
    {
        return new ($this->entityClassName());
    }

    public function getRate(int $fromId, int $toId): ExchangeRate|null
    {
        return $this->getEntity()->newQuery()
            ->where('from_currency_id', $fromId)
            ->where('to_currency_id', $toId)
            ->first();
    }
}
