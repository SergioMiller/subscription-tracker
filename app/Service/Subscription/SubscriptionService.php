<?php
declare(strict_types=1);

namespace App\Service\Subscription;

use App\Entities\Subscription;
use App\Entities\User;
use App\Interfaces\Repositories\SubscriptionRepositoryInterface;
use App\Service\Subscription\Dto\StoreDto;
use App\Service\Subscription\Dto\UpdateDto;

final readonly class SubscriptionService
{
    public function __construct(private SubscriptionRepositoryInterface $subscriptionRepository)
    {
    }

    public function store(User $user, StoreDto $data): Subscription
    {
        return new Subscription();
    }

    public function update(Subscription $entity, UpdateDto $data): Subscription
    {
        return $entity;
    }

    public function destroy(Subscription $entity): bool
    {
        return $this->subscriptionRepository->destroy($entity);
    }
}
