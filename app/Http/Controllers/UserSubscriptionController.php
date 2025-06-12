<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Entities\UserSubscription;
use App\Enums\Filter\FilterPriceEnum;
use App\Enums\Subscription\SubscriptionTypeEnum;
use App\Http\Requests\MySubscription\IndexRequest;
use App\Interfaces\Repositories\UserSubscriptionRepositoryInterface;
use App\Service\ExchangeRate\ExchangeRateService;
use App\Service\Forecast\ForecastService;
use App\Service\Stat\StatService;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;

final class UserSubscriptionController extends Controller
{
    public function __construct(
        private readonly UserSubscriptionRepositoryInterface $userSubscriptionRepository,
        private readonly ExchangeRateService $exchangeRateService,
        private readonly ForecastService $forecastService,
        private readonly StatService $statService,
    ) {
    }

    public function index(IndexRequest $request): View
    {
        $user = $request->user();
        $paginator = $this->userSubscriptionRepository->paginate($request->user(), $request->query());
        $subscriptions = $this->userSubscriptionRepository->activeSubscriptions($user, ['subscription.currency']);

        return view('user-subscriptions.index', [
            'paginator' => $paginator,
            'items' => (new Collection($paginator->items()))
                ->map(function (UserSubscription $item) use ($user) {
                    $userPrice = $this->exchangeRateService->getUserPrice(
                        currency: $item->currency,
                        userCurrency: $user->defaultCurrency,
                        price: $item->price
                    );

                    $item->setUserPrice($userPrice)->setUserCurrency($user->defaultCurrency);

                    return $item;
                }),
            'forecast' => $this->forecastService->get($user, $subscriptions),
            'stat' => $this->statService->get($user, $subscriptions),
            'filter' => [
                'data' => [
                    'type' => SubscriptionTypeEnum::values(),
                    'price' => FilterPriceEnum::values(),
                ],
                'filled' => $request->query(),
            ]
        ]);
    }
}
