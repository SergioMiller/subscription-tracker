<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Enums\Subscription\SubscriptionTypeEnum;
use App\Http\Requests\Subscription\StoreRequest;
use App\Http\Requests\Subscription\UpdateRequest;
use App\Interfaces\Repositories\CurrencyRepositoryInterface;
use App\Interfaces\Repositories\SubscriptionRepositoryInterface;
use App\Interfaces\Repositories\UserSubscriptionRepositoryInterface;
use App\Service\Subscription\Dto\StoreDto;
use App\Service\Subscription\Dto\UpdateDto;
use App\Service\Subscription\SubscriptionService;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

final class SubscriptionController extends Controller
{
    public function __construct(
        private readonly SubscriptionRepositoryInterface $subscriptionRepository,
        private readonly UserSubscriptionRepositoryInterface $userSubscriptionRepository,
        private readonly SubscriptionService $subscriptionService,
        private readonly CurrencyRepositoryInterface $currencyRepository,
    ) {
    }

    public function index(Request $request): View
    {
        $activeSubscriptions = $this->userSubscriptionRepository->activeSubscriptions($request->user())
            ->pluck('subscription_id')
            ->toArray();

        $paginator = $this->subscriptionRepository->paginate([]);

        return view('subscriptions.index', [
            'active_subscriptions' => $activeSubscriptions,
            'paginator' => $paginator,
        ]);
    }

    public function create(): View
    {
        return view('subscriptions.create', [
            'currencies' => $this->currencyRepository->getAll(),
            'types' => SubscriptionTypeEnum::array(),
        ]);
    }

    public function store(StoreRequest $request): RedirectResponse
    {
        $this->subscriptionService->store(StoreDto::fromArray($request->validated()));

        return redirect()->route('subscriptions.index')->with('success', 'Successfully.');
    }

    public function edit(int $id): View
    {
        $entity = $this->subscriptionRepository->getByKey($id);

        abort_if(null === $entity, Response::HTTP_NOT_FOUND);

        return view('subscriptions.edit', [
            'entity' => $entity,
            'currencies' => $this->currencyRepository->getAll(),
            'types' => SubscriptionTypeEnum::array(),
        ]);
    }

    public function update(int $id, UpdateRequest $request): RedirectResponse
    {
        $entity = $this->subscriptionRepository->getByKey($id);

        abort_if(null === $entity, Response::HTTP_NOT_FOUND);

        $this->subscriptionService->update($entity, UpdateDto::fromArray($request->validated()));

        return redirect()->route('subscriptions.index')->with('success', 'Successfully.');
    }

    public function destroy(int $id): RedirectResponse
    {
        $entity = $this->subscriptionRepository->getByKey($id);

        abort_if(null === $entity, Response::HTTP_NOT_FOUND);

        $this->subscriptionService->destroy($entity);

        return redirect()->route('subscriptions.index')->with('success', 'Successfully.');
    }

    public function subscribe(int $id, Request $request): RedirectResponse
    {
        $entity = $this->subscriptionRepository->getByKey($id);

        abort_if(null === $entity, Response::HTTP_NOT_FOUND);

        try {
            $this->subscriptionService->subscribe($request->user(), $entity);
        } catch (UnprocessableEntityHttpException $e) {
            abort(code: Response::HTTP_UNPROCESSABLE_ENTITY, message: $e->getMessage());
        }

        return redirect()->route('subscriptions.index')->with('success', 'Successfully.');
    }

    public function unsubscribe(int $id, Request $request): RedirectResponse
    {
        $entity = $this->subscriptionRepository->getByKey($id);

        abort_if(null === $entity, Response::HTTP_NOT_FOUND);

        try {
            $this->subscriptionService->unsubscribe($request->user(), $entity);
        } catch (ModelNotFoundException $e) {
            abort(code: Response::HTTP_NOT_FOUND, message: $e->getMessage());
        }

        return redirect()->route('subscriptions.index')->with('success', 'Successfully.');
    }
}
