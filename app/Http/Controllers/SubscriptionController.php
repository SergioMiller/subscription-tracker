<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\Subscription\StoreRequest;
use App\Http\Requests\Subscription\UpdateRequest;
use App\Interfaces\Repositories\CurrencyRepositoryInterface;
use App\Interfaces\Repositories\SubscriptionRepositoryInterface;
use App\Service\Subscription\Dto\StoreDto;
use App\Service\Subscription\Dto\UpdateDto;
use App\Service\Subscription\SubscriptionService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

final  class SubscriptionController extends Controller
{
    public function __construct(
        private readonly SubscriptionRepositoryInterface $subscriptionRepository,
        private readonly SubscriptionService $subscriptionService,
        private readonly CurrencyRepositoryInterface $currencyRepository,
    ) {
    }

    public function index(Request $request): View
    {
        $paginator = $this->subscriptionRepository->paginate([]);

        return view('subscriptions.index', ['paginator' => $paginator]);
    }

    public function create(): View
    {
        return view('subscriptions.create', [
            'currencies' => $this->currencyRepository->getAll(),
        ]);
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
