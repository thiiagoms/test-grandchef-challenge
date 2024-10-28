<?php

namespace App\Providers;

use App\Common\Paginator;
use App\Contracts\Common\PaginatorContract;
use Illuminate\Support\ServiceProvider;

class AppCommonProvider extends ServiceProvider
{
    private array $commons = [
        PaginatorContract::class => Paginator::class,
    ];

    /**
     * Register services.
     */
    public function register(): void
    {
        foreach ($this->commons as $contract => $common) {
            $this->app->singleton($contract, $common);
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
