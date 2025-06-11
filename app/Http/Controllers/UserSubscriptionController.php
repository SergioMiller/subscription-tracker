<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Entities\UserSubscription;
use App\Interfaces\Repositories\UserSubscriptionRepositoryInterface;
use App\Service\ExchangeRate\ExchangeRateService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

final class UserSubscriptionController extends Controller
{
    public function __construct(
        private readonly UserSubscriptionRepositoryInterface $userSubscriptionRepository,
        private readonly ExchangeRateService $exchangeRateService
    ) {
    }

    public function index(Request $request): View
    {
        $user = $request->user();
        $paginator = $this->userSubscriptionRepository->paginate($request->user());

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
        ]);
    }
}
