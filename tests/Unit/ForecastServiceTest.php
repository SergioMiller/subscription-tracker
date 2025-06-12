<?php
declare(strict_types=1);

namespace Tests\Unit;

use App\Entities\Currency;
use App\Enums\Subscription\SubscriptionTypeEnum;
use App\Service\Forecast\ForecastService;
use App\Service\Subscription\SubscriptionService;
use Database\Factories\SubscriptionFactory;
use Database\Factories\UserFactory;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\Collection;
use Tests\TestCase;

/**
 * @see ForecastService
 */
class ForecastServiceTest extends TestCase
{
    private SubscriptionService $subscriptionService;

    private ForecastService $forecastService;

    private Currency $usd;

    private Currency $eur;

    private Currency $uah;

    /**
     * @throws BindingResolutionException
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->subscriptionService = $this->app->make(SubscriptionService::class);
        $this->forecastService = $this->app->make(ForecastService::class);

        $currencies = Currency::query()->get()->keyBy('code');
        $this->usd = $currencies[Currency::USD];
        $this->eur = $currencies[Currency::EUR];
        $this->uah = $currencies[Currency::UAH];
    }

    public function test_get(): void
    {
        $currencies = [
            [
                'currency' => $this->usd,
                'total30' => 39.19,
                'total365' => 488.42,
            ],
            [
                'currency' => $this->eur,
                'total30' => 34.16,
                'total365' => 425.79,
            ],
            [
                'currency' => $this->uah,
                'total30' => 1609.0,
                'total365' => 20053.0,
            ]
        ];

        $currentCurrency = $this->faker->randomElement($currencies);

        $user = UserFactory::new()->create(['default_currency_id' => $currentCurrency['currency']->getKey()]);

        $subscriptions = [
            SubscriptionFactory::new()->create([
                'type' => SubscriptionTypeEnum::DAILY,
                'price' => 100,
                'currency_id' => $this->usd->getKey()
            ]),
            SubscriptionFactory::new()->create([
                'type' => SubscriptionTypeEnum::WEEKLY,
                'price' => 200,
                'currency_id' => $this->eur->getKey()
            ]),
            SubscriptionFactory::new()->create([
                'type' => SubscriptionTypeEnum::MONTHLY,
                'price' => 300,
                'currency_id' => $this->uah->getKey()
            ]),
            SubscriptionFactory::new()->create([
                'type' => SubscriptionTypeEnum::YEARLY,
                'price' => 400,
                'currency_id' => $this->usd->getKey()
            ]),
        ];

        $userSubscriptions = new Collection();
        foreach ($subscriptions as $subscription) {
            $userSubscriptions->push($this->subscriptionService->subscribe($user, $subscription));
        }

        $result = $this->forecastService->get($user, $userSubscriptions);

        $this->assertSame($result->getTotal30(), $currentCurrency['total30']);
        $this->assertSame($result->getTotal365(), $currentCurrency['total365']);
    }
}
