<?php
declare(strict_types=1);

namespace Database\Seeders;

use App\Entities\Currency;
use App\Entities\ExchangeRate;
use App\Entities\Subscription;
use App\Entities\User;
use App\Enums\Subscription\SubscriptionTypeEnum;
use App\Service\Subscription\Dto\StoreDto;
use App\Service\Subscription\SubscriptionService;
use Carbon\Carbon;
use Database\Factories\UserFactory;
use Illuminate\Database\Seeder;

final class DatabaseSeeder extends Seeder
{
    public function __construct(private readonly SubscriptionService $subscriptionService)
    {
    }

    public function run(): void
    {
        $createdAt = Carbon::now()->toDateTimeString();

        Currency::query()->insertOrIgnore([
            [
                'id' => Currency::DEFAULT_CURRENCY_ID,
                'name' => 'US Dollar',
                'code' => Currency::USD,
                'symbol' => '$',
                'created_at' => $createdAt
            ],
            [
                'id' => 2,
                'name' => 'Euro',
                'code' => 'EUR',
                'symbol' => '€',
                'created_at' => $createdAt
            ],
            [
                'id' => 3,
                'name' => 'Hryvnia',
                'code' => 'UAH',
                'symbol' => '₴',
                'created_at' => $createdAt
            ],
        ]);

        ExchangeRate::query()->truncate();

        $currencies = Currency::query()->get()->keyBy('code');

        $usdId = $currencies[Currency::USD]->getKey();
        $eurId = $currencies[Currency::EUR]->getKey();
        $uahId = $currencies[Currency::UAH]->getKey();

        $rates = [
            // USD
            ['from_currency_id' => $usdId, 'to_currency_id' => $eurId, 'rate' => 0.87],
            ['from_currency_id' => $usdId, 'to_currency_id' => $uahId, 'rate' => 41.00],

            // EUR
            ['from_currency_id' => $eurId, 'to_currency_id' => $usdId, 'rate' => 1.14],
            ['from_currency_id' => $eurId, 'to_currency_id' => $uahId, 'rate' => 47.00],

            // UAH
            ['from_currency_id' => $uahId, 'to_currency_id' => $usdId, 'rate' => 0.024],
            ['from_currency_id' => $uahId, 'to_currency_id' => $eurId, 'rate' => 0.021],
        ];

        ExchangeRate::query()->insert($rates);
        ExchangeRate::query()->update(['created_at' => $createdAt]);

        if (User::query()->where('email', 'test@example.com')->doesntExist()) {
            UserFactory::new()->create([
                'name' => 'Test User',
                'email' => 'test@example.com',
                'default_currency_id' => $usdId,
            ]);
        }

        Subscription::query()->truncate();

        $subscriptions = [
            new StoreDto(
                name: 'Netflix',
                description: 'Watch movies.',
                price: 19.99,
                currencyId: $usdId,
                type: SubscriptionTypeEnum::MONTHLY,
            ),
            new StoreDto(
                name: 'PhpStorm',
                description: 'Write the code.',
                price: 2.99,
                currencyId: $eurId,
                type: SubscriptionTypeEnum::WEEKLY,
            ),
            new StoreDto(
                name: 'Tinder',
                description: 'Have a good date.',
                price: 24.99,
                currencyId: $uahId,
                type: SubscriptionTypeEnum::DAILY,
            )
        ];

        foreach ($subscriptions as $subscription) {
            $this->subscriptionService->store($subscription);
        }
    }
}
