<?php
declare(strict_types=1);

namespace App\Service\Subscription;

use App\Entities\Subscription;
use App\Entities\User;
use App\Entities\UserSubscription;
use App\Enums\Subscription\SubscriptionStatusEnum;
use App\Enums\Subscription\SubscriptionTypeEnum;
use App\Interfaces\Repositories\SubscriptionRepositoryInterface;
use App\Interfaces\Repositories\UserSubscriptionRepositoryInterface;
use App\Service\ExchangeRate\ExchangeRateService;
use App\Service\Subscription\Dto\StoreDto;
use App\Service\Subscription\Dto\UpdateDto;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

final readonly class SubscriptionService
{
    public function __construct(
        private SubscriptionRepositoryInterface $subscriptionRepository,
        private ExchangeRateService $exchangeRateService,
        private UserSubscriptionRepositoryInterface $userSubscriptionRepository,
    ) {
    }

    public function store(StoreDto $data): Subscription
    {
        $entity = new Subscription();
        $entity->name = $data->getName();
        $entity->description = $data->getDescription();
        $entity->price = (int) ($data->getPrice() * 100);
        $entity->currency_id = $data->getCurrencyId();
        $entity->type = $data->getType();

        $entity->base_price = $this->exchangeRateService->getBasePrice($entity->currency, $entity->price);

        return $this->subscriptionRepository->save($entity);
    }

    public function update(Subscription $entity, UpdateDto $data): Subscription
    {
        $entity->name = $data->getName();
        $entity->description = $data->getDescription();
        $entity->price = (int) ($data->getPrice() * 100);
        $entity->currency_id = $data->getCurrencyId();
        $entity->type = $data->getType();
        $entity->base_price = $this->exchangeRateService->getBasePrice($entity->currency, $entity->price);

        return $this->subscriptionRepository->save($entity);
    }

    public function destroy(Subscription $entity): bool
    {
        return $this->subscriptionRepository->destroy($entity);
    }

    public function subscribe(User $user, Subscription $entity): UserSubscription
    {
        $currentSubscription = $this->userSubscriptionRepository->getBySubscription($user, $entity);

        if (null !== $currentSubscription && $currentSubscription->finish_at->isFuture()) {
            throw new UnprocessableEntityHttpException('Subscription already exists.');
        }

        $userSubscription = new UserSubscription();
        $userSubscription->user_id = $user->getKey();
        $userSubscription->subscription_id = $entity->getKey();
        $userSubscription->currency_id = $entity->currency->getKey();
        $userSubscription->price = $entity->price;
        $userSubscription->base_price = $entity->base_price;
        $userSubscription->status = SubscriptionStatusEnum::ACTIVE;

        $now = Carbon::now();
        $userSubscription->start_at = $now;
        $userSubscription->finish_at = match ($entity->type) {
            SubscriptionTypeEnum::DAILY => $now->addDay(),
            SubscriptionTypeEnum::WEEKLY => $now->addWeek(),
            SubscriptionTypeEnum::MONTHLY => $now->addMonth(),
            SubscriptionTypeEnum::YEARLY => $now->addYear(),
        };

        return $this->userSubscriptionRepository->save($userSubscription);
    }

    public function unsubscribe(User $user, Subscription $entity): UserSubscription
    {
        $userSubscription = $this->userSubscriptionRepository->getBySubscription($user, $entity);

        if (null === $userSubscription) {
            throw new ModelNotFoundException(message: 'Subscription not found.');
        }

        $userSubscription->status = SubscriptionStatusEnum::UNSUBSCRIBED;

        return $this->userSubscriptionRepository->save($userSubscription);
    }
}
