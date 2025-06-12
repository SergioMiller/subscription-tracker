<?php
declare(strict_types=1);

namespace App\Service\Stat;

use App\Entities\User;
use App\Entities\UserSubscription;
use App\Service\ExchangeRate\ExchangeRateService;
use App\Service\Stat\Dto\ResultDto;
use Illuminate\Support\Collection;

final readonly class StatService
{
    public function __construct(private ExchangeRateService $exchangeRateService)
    {
    }

    public function get(User $user, Collection $subscriptions): ResultDto
    {
        /**
         * @var Collection|UserSubscription[] $subscriptions
         */
        $prices = [];
        foreach ($subscriptions as $sub) {
            $prices[] = $this->exchangeRateService->getUserPrice(
                currency: $sub->subscription->currency,
                userCurrency: $user->defaultCurrency,
                price: $sub->subscription->price,
            );
        }

        return new ResultDto(
            quantity: $subscriptions->count(),
            amount: round(array_sum($prices) / 100, 2),
            average: round(array_sum($prices) / count($prices) / 100, 2),
            currency: $user->defaultCurrency,
        );
    }
}
