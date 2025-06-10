<?php
declare(strict_types=1);

namespace App\Providers;

use App\Interfaces\Repositories\CurrencyRepositoryInterface;
use App\Interfaces\Repositories\ExchangeRateRepositoryInterface;
use App\Interfaces\Repositories\SubscriptionRepositoryInterface;
use App\Interfaces\Repositories\UserRepositoryInterface;
use App\Interfaces\Repositories\UserSubscriptionRepositoryInterface;
use App\Repositories\CurrencyRepository;
use App\Repositories\ExchangeRateRepository;
use App\Repositories\SubscriptionRepository;
use App\Repositories\UserRepository;
use App\Repositories\UserSubscriptionRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(SubscriptionRepositoryInterface::class, SubscriptionRepository::class);
        $this->app->bind(CurrencyRepositoryInterface::class, CurrencyRepository::class);
        $this->app->bind(ExchangeRateRepositoryInterface::class, ExchangeRateRepository::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(UserSubscriptionRepositoryInterface::class, UserSubscriptionRepository::class);
    }

    public function boot(): void
    {
    }
}
