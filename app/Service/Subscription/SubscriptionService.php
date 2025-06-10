<?php
declare(strict_types=1);

namespace App\Service\Subscription;

use App\Entities\Subscription;
use App\Entities\User;
use App\Interfaces\Repositories\SubscriptionRepositoryInterface;
use App\Service\ExchangeRate\ExchangeRateService;
use App\Service\Subscription\Dto\StoreDto;
use App\Service\Subscription\Dto\UpdateDto;

final readonly class SubscriptionService
{
    public function __construct(
        private SubscriptionRepositoryInterface $subscriptionRepository,
        private ExchangeRateService $exchangeRateService,
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

//        if ($entity->base_price !== $entity->price) {
            $entity->base_price = $this->exchangeRateService->getBasePrice($entity->currency, $entity->price);
//        }

        return $this->subscriptionRepository->save($entity);
    }

    public function destroy(Subscription $entity): bool
    {
        return $this->subscriptionRepository->destroy($entity);
    }
}
