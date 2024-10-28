<?php

namespace App\Http\Controllers\Api\Product;

use App\Contracts\Services\Product\All\ProductAllServiceContract;
use App\Contracts\Services\Product\Destroy\DestroyProductServiceContract;
use App\Contracts\Services\Product\Register\RegisterProductServiceContract;
use App\Contracts\Services\Product\Update\UpdateProductServiceContract;
use App\Http\Controllers\Controller;

abstract class BaseProductApiController extends Controller
{
    public function __construct(
        protected readonly RegisterProductServiceContract $registerProductService,
        protected readonly UpdateProductServiceContract $updateProductService,
        protected readonly DestroyProductServiceContract $destroyProductService,
        protected readonly ProductAllServiceContract $getAllProductsService,
    ) {}
}
