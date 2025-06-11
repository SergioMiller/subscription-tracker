<?php
declare(strict_types=1);

namespace App\Service\Stat;

use App\Entities\User;
use App\Entities\UserSubscription;
use App\Enums\Subscription\SubscriptionTypeEnum;
use App\Interfaces\Repositories\UserSubscriptionRepositoryInterface;
use App\Service\ExchangeRate\ExchangeRateService;
use App\Service\Stat\Dto\ResultDto;
use Illuminate\Support\Collection;

final readonly class StatService
{
    public function __construct(
        private UserSubscriptionRepositoryInterface $userSubscriptionRepository,
        private ExchangeRateService $exchangeRateService,
    ) {
    }

    public function get(User $user): ResultDto
    {
        /**
         * @var Collection|UserSubscription[] $subscriptions
         */
        $subscriptions = $this->userSubscriptionRepository->activeSubscriptions($user, [
            'subscription.currency'
        ]);

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
