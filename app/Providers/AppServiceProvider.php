<?php

namespace App\Providers;

use App\Contracts\Services\Category\All\CategoryAllServiceContract;
use App\Contracts\Services\Category\Destroy\DestroyCategoryServiceContract;
use App\Contracts\Services\Category\Find\FindCategoryByIdServiceContract;
use App\Contracts\Services\Category\Register\RegisterCategoryServiceContract;
use App\Contracts\Services\Category\Update\UpdateCategoryServiceContract;
use App\Contracts\Services\Product\All\ProductAllServiceContract;
use App\Contracts\Services\Product\Destroy\DestroyProductServiceContract;
use App\Contracts\Services\Product\Find\FindProductByIdServiceContract;
use App\Contracts\Services\Product\Register\RegisterProductServiceContract;
use App\Contracts\Services\Product\Update\UpdateProductServiceContract;
use App\Services\Category\All\CategoryAllService;
use App\Services\Category\Destroy\DestroyCategoryService;
use App\Services\Category\Find\FindCategoryByIdService;
use App\Services\Category\Register\RegisterCategoryService;
use App\Services\Category\Update\UpdateCategoryService;
use App\Services\Product\All\ProductAllService;
use App\Services\Product\Destroy\DestroyProductService;
use App\Services\Product\Find\FindProductByIdService;
use App\Services\Product\Register\RegisterProductService;
use App\Services\Product\Update\UpdateProductService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    private array $services = [
        /** Category */
        RegisterCategoryServiceContract::class => RegisterCategoryService::class,
        FindCategoryByIdServiceContract::class => FindCategoryByIdService::class,
        UpdateCategoryServiceContract::class => UpdateCategoryService::class,
        DestroyCategoryServiceContract::class => DestroyCategoryService::class,
        CategoryAllServiceContract::class => CategoryAllService::class,
        /** Product */
        RegisterProductServiceContract::class => RegisterProductService::class,
        UpdateProductServiceContract::class => UpdateProductService::class,
        FindProductByIdServiceContract::class => FindProductByIdService::class,
        DestroyProductServiceContract::class => DestroyProductService::class,
        ProductAllServiceContract::class => ProductAllService::class,
    ];

    /**
     * Register any application services.
     */
    public function register(): void
    {
        foreach ($this->services as $contract => $service) {
            $this->app->singleton($contract, $service);
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
