<?php
declare(strict_types=1);

namespace Tests\Unit;

use App\Entities\Currency;
use App\Service\ExchangeRate\ExchangeRateService;
use Illuminate\Contracts\Container\BindingResolutionException;
use Psr\SimpleCache\InvalidArgumentException;
use Tests\TestCase;

/**
 * @see ExchangeRateService
 */
class ExchangeRateServiceTest extends TestCase
{
    private ExchangeRateService $exchangeRateService;

    private Currency $usd;

    private Currency $eur;

    private Currency $uah;

    /**
     * @throws BindingResolutionException
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->exchangeRateService = $this->app->make(ExchangeRateService::class);

        $currencies = Currency::query()->get()->keyBy('code');
        $this->usd = $currencies[Currency::USD];
        $this->eur = $currencies[Currency::EUR];
        $this->uah = $currencies[Currency::UAH];
    }

    /**
     * @throws InvalidArgumentException
     */
    public function test_get_base_price_from_usd(): void
    {
        $result = $this->exchangeRateService->getBasePrice($this->usd, 100);

        $this->assertSame(100.0, $result);
    }

    /**
     * @throws InvalidArgumentException
     */
    public function test_get_base_price_from_eur(): void
    {
        $result = $this->exchangeRateService->getBasePrice($this->eur, 100);

        $this->assertSame(114.0, $result);
    }

    /**
     * @throws InvalidArgumentException
     */
    public function test_get_base_price_from_uah(): void
    {
        $result = $this->exchangeRateService->getBasePrice($this->uah, 100);

        $this->assertSame(2.4, $result);
    }

    /**
     * @throws InvalidArgumentException
     */
    public function test_get_user_price_usd_to_usd(): void
    {
        $result = $this->exchangeRateService->getUserPrice($this->usd, $this->usd, 100);

        $this->assertSame(100.0, $result);
    }

    /**
     * @throws InvalidArgumentException
     */
    public function test_get_user_price_usd_to_eur(): void
    {
        $result = $this->exchangeRateService->getUserPrice($this->usd, $this->eur, 100);

        $this->assertSame(87.0, $result);
    }

    /**
     * @throws InvalidArgumentException
     */
    public function test_get_user_price_eur_to_usd(): void
    {
        $result = $this->exchangeRateService->getUserPrice($this->eur, $this->usd, 100);

        $this->assertSame(114.0, $result);
    }

    /**
     * @throws InvalidArgumentException
     */
    public function test_get_user_price_eur_to_eur(): void
    {
        $result = $this->exchangeRateService->getUserPrice($this->eur, $this->eur, 100);

        $this->assertSame(100.0, $result);
    }

    /**
     * @throws InvalidArgumentException
     */
    public function test_get_user_price_eur_to_uah(): void
    {
        $result = $this->exchangeRateService->getUserPrice($this->eur, $this->uah, 100);

        $this->assertSame(4700.0, $result);
    }

    /**
     * @throws InvalidArgumentException
     */
    public function test_get_user_price_uah_to_usd(): void
    {
        $result = $this->exchangeRateService->getUserPrice($this->uah, $this->usd, 100);

        $this->assertSame(2.4, $result);
    }

    /**
     * @throws InvalidArgumentException
     */
    public function test_get_user_price_uah_to_eur(): void
    {
        $result = $this->exchangeRateService->getUserPrice($this->uah, $this->eur, 100);

        $this->assertSame(2.1, $result);
    }

    /**
     * @throws InvalidArgumentException
     */
    public function test_get_user_price_uah_to_uah(): void
    {
        $result = $this->exchangeRateService->getUserPrice($this->uah, $this->uah, 100);

        $this->assertSame(100.0, $result);
    }
}
