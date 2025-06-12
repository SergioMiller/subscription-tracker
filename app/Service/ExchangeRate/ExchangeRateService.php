<?php
declare(strict_types=1);

namespace App\Service\ExchangeRate;

use App\Entities\Currency;
use App\Interfaces\Repositories\ExchangeRateRepositoryInterface;
use Illuminate\Cache\CacheManager;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Psr\SimpleCache\InvalidArgumentException;

/**
 * @see ExchangeRateServiceTest
 */
final readonly class ExchangeRateService
{
    public function __construct(
        private ExchangeRateRepositoryInterface $exchangeRateRepository,
        private CacheManager $cache,
    ) {
    }

    /**
     * @throws InvalidArgumentException
     */
    public function getBasePrice(Currency $currency, int $price): float
    {
        if (Currency::DEFAULT_CURRENCY_ID === $currency->getKey()) {
            return $price;
        }

        $rate = $this->getRate($currency->getKey(), Currency::DEFAULT_CURRENCY_ID);

        return $this->applyRate($price, $rate);
    }

    /**
     * @throws InvalidArgumentException
     */
    public function getUserPrice(Currency $currency, Currency $userCurrency, int $price): float
    {
        if ($currency->getKey() === $userCurrency->getKey()) {
            return $price;
        }

        $rate = $this->getRate($currency->getKey(), $userCurrency->getKey());

        return $this->applyRate($price, $rate);
    }

    /**
     * @throws InvalidArgumentException
     */
    private function getRate(int $from, int $to): float|null
    {
        $pattern = sprintf('exchange_rate_%s_%s', $from, $to);
        $rate = $this->cache->get($pattern);

        if (null === $rate) {
            $rate = $this->exchangeRateRepository->getRate($from, $to)?->getAttribute('rate');
        }

        if (null === $rate) {
            throw new ModelNotFoundException('Rate not found.');
        }

        $this->cache->set(key: $pattern, value: $rate, ttl: 60);

        return $rate;
    }

    private function applyRate(int $price, float $rate): float
    {
        return round($price * $rate, 2);
    }
}
