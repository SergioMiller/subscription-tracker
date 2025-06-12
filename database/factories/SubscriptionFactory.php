<?php
declare(strict_types=1);

namespace Database\Factories;

use App\Entities\Currency;
use App\Entities\Subscription;
use App\Enums\Subscription\SubscriptionTypeEnum;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Subscription>
 */
final class SubscriptionFactory extends Factory
{
    protected $model = Subscription::class;

    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'description' => fake()->unique()->text(),
            'price' => fake()->numberBetween(100, 1000),
            'base_price' => fake()->numberBetween(100, 1000),
            'currency_id' => Currency::query()->get()->random()->first()->getKey(),
            'type' => fake()->randomElement(SubscriptionTypeEnum::values()),
        ];
    }
}
