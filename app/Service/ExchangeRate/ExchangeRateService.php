<?php
declare(strict_types=1);

namespace App\Service\ExchangeRate;

use App\Entities\Currency;
use App\Interfaces\Repositories\ExchangeRateRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;

final readonly class ExchangeRateService
{
    public function __construct(
        private ExchangeRateRepositoryInterface $exchangeRateRepository,
    ) {
    }

    public function getBasePrice(Currency $currency, int $price): int
    {
        if ($currency->getKey() === Currency::DEFAULT_CURRENCY_ID) {
            return $price;
        }

        $rate = $this->exchangeRateRepository->getRate(
            fromId: $currency->getKey(),
            toId: Currency::DEFAULT_CURRENCY_ID
        );

        if (null === $rate) {
            throw new ModelNotFoundException('Rate not found.');
        }

        return (int) ($price * $rate->rate);
    }
}
