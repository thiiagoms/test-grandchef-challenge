<?php

namespace App\Providers;

use App\Contracts\Repositories\Category\CategoryRepositoryContract;
use App\Contracts\Repositories\Product\ProductRepositoryContract;
use App\Repositories\Category\CategoryRepository;
use App\Repositories\Product\ProductRepository;
use Illuminate\Support\ServiceProvider;

class AppRepositoryProvider extends ServiceProvider
{
    private array $repositories = [
        CategoryRepositoryContract::class => CategoryRepository::class,
        ProductRepositoryContract::class => ProductRepository::class,
    ];

    /**
     * Register services.
     */
    public function register(): void
    {
        foreach ($this->repositories as $contract => $repository) {
            $this->app->singleton($contract, $repository);
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
