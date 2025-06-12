<?php
declare(strict_types=1);

namespace Tests\Unit;

use App\Enums\Subscription\SubscriptionStatusEnum;
use App\Service\ExchangeRate\ExchangeRateService;
use App\Service\Subscription\SubscriptionService;
use Database\Factories\SubscriptionFactory;
use Database\Factories\UserFactory;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;
use Tests\TestCase;

/**
 * @see SubscriptionService
 */
class SubscriptionServiceTest extends TestCase
{
    private SubscriptionService $subscriptionService;

    /**
     * @throws BindingResolutionException
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->subscriptionService = $this->app->make(SubscriptionService::class);
        $this->exchangeRateService = $this->app->make(ExchangeRateService::class);
    }

    public function test_subscribe(): void
    {
        $user = UserFactory::new()->create();
        $subscription = SubscriptionFactory::new()->create();

        $result = $this->subscriptionService->subscribe($user, $subscription);

        $this->assertSame(SubscriptionStatusEnum::ACTIVE, $result->status);
        $this->assertSame($user->id, $result->user_id);
        $this->assertSame($subscription->id, $result->subscription_id);
        $this->assertSame($subscription->currency_id, $result->currency_id);
        $this->assertSame($subscription->price, $result->price);
        $this->assertSame($subscription->base_price, $result->base_price);
    }

    public function test_subscribe_user_has_subscription(): void
    {
        $user = UserFactory::new()->create();
        $subscription = SubscriptionFactory::new()->create();

        $this->subscriptionService->subscribe($user, $subscription);

        $this->expectException(UnprocessableEntityHttpException::class);
        $this->expectExceptionMessage('Subscription already exists.');

        $this->subscriptionService->subscribe($user, $subscription);
    }

    public function test_unsubscribe(): void
    {
        $user = UserFactory::new()->create();
        $subscription = SubscriptionFactory::new()->create();

        $this->subscriptionService->subscribe($user, $subscription);
        $result = $this->subscriptionService->unsubscribe($user, $subscription);

        $this->assertSame(SubscriptionStatusEnum::UNSUBSCRIBED, $result->status);
    }

    public function test_unsubscribe_not_exists(): void
    {
        $user = UserFactory::new()->create();
        $subscription = SubscriptionFactory::new()->create();

        $this->expectException(ModelNotFoundException::class);
        $this->expectExceptionMessage('Subscription not found.');

        $this->subscriptionService->unsubscribe($user, $subscription);
    }
}
