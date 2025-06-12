<?php
declare(strict_types=1);

namespace App\Service\Forecast;

use App\Entities\User;
use App\Entities\UserSubscription;
use App\Enums\Subscription\SubscriptionTypeEnum;
use App\Service\ExchangeRate\ExchangeRateService;
use App\Service\Forecast\Dto\ResultDto;
use Carbon\Carbon;
use Illuminate\Support\Collection;

/**
 * @see ForecastServiceTest
 */
final readonly class ForecastService
{
    public function __construct(private ExchangeRateService $exchangeRateService)
    {
    }

    public function get(User $user, Collection $subscriptions): ResultDto
    {
        $now = now();
        $end30 = $now->copy()->addDays(30);
        $end365 = $now->copy()->addDays(365);

        $total30 = 0;
        $total365 = 0;

        /**
         * @var UserSubscription[] $subscriptions
         */
        foreach ($subscriptions as $sub) {
            $start = Carbon::parse($sub['start_at']);

            $rate = $this->exchangeRateService->getUserPrice(
                currency: $sub->subscription->currency,
                userCurrency: $user->defaultCurrency,
                price: $sub->subscription->price,
            );

            $interval = match ($sub->subscription->type) {
                SubscriptionTypeEnum::DAILY => '1 day',
                SubscriptionTypeEnum::WEEKLY => '1 week',
                SubscriptionTypeEnum::MONTHLY => '1 month',
                SubscriptionTypeEnum::YEARLY => '1 year',
            };

            $chargeDate = $start->copy();

            while ($chargeDate <= $end365) {
                if ($chargeDate >= $now) {
                    if ($chargeDate <= $end30) {
                        $total30 += $rate;
                    }
                    $total365 += $rate;
                }

                $chargeDate->add($interval);
            }
        }

        return new ResultDto(
            total30: round($total30 / 100, 2),
            total365: round($total365 / 100, 2),
            currency: $user->defaultCurrency,
        );
    }
}
