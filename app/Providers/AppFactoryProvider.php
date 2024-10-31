<?php

namespace App\Providers;

use App\Contracts\Factories\Order\Register\RegisterOrderFactoryContract;
use App\Factories\Order\Register\RegisterOrderFactory;
use Illuminate\Support\ServiceProvider;

class AppFactoryProvider extends ServiceProvider
{
    private array $factories = [
        RegisterOrderFactoryContract::class => RegisterOrderFactory::class,
    ];

    /**
     * Register services.
     */
    public function register(): void
    {
        foreach ($this->factories as $contract => $factory) {
            $this->app->bind($contract, $factory);
        }
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
