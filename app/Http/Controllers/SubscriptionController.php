<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\Subscription\StoreRequest;
use App\Http\Requests\Subscription\UpdateRequest;
use App\Interfaces\Repositories\SubscriptionRepositoryInterface;
use App\Service\Subscription\Dto\StoreDto;
use App\Service\Subscription\Dto\UpdateDto;
use App\Service\Subscription\SubscriptionService;
use Symfony\Component\HttpFoundation\Response;

final readonly class SubscriptionController
{
    public function __construct(
        private SubscriptionRepositoryInterface $subscriptionRepository,
        private SubscriptionService $subscriptionService,
    ) {
    }

    public function store(StoreRequest $request): void
    {
        $this->subscriptionService->store($request->user(), StoreDto::fromArray($request->validated()));
    }

    public function edit(int $id): void
    {
        $entity = $this->subscriptionRepository->getByKey($id);

        abort_if(null === $entity, Response::HTTP_NOT_FOUND);
    }

    public function update(int $id, UpdateRequest $request): void
    {
        $entity = $this->subscriptionRepository->getByKey($id);

        abort_if(null === $entity, Response::HTTP_NOT_FOUND);

        $this->subscriptionService->update($entity, UpdateDto::fromArray($request->validated()));
    }

    public function destroy(int $id): void
    {
        $entity = $this->subscriptionRepository->getByKey($id);

        abort_if(null === $entity, Response::HTTP_NOT_FOUND);

        $this->subscriptionService->destroy($entity);
    }
}
