<?php

declare(strict_types=1);

namespace App\Services\Product\All;

use App\Contracts\Common\PaginatorContract;
use App\Contracts\Repositories\Product\ProductRepositoryContract;
use App\Contracts\Services\Product\All\ProductAllServiceContract;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ProductAllService implements ProductAllServiceContract
{
    public function __construct(
        private readonly ProductRepositoryContract $productRepository,
        private readonly PaginatorContract $paginator
    ) {}

    public function handle(): LengthAwarePaginator
    {
        $products = $this->productRepository->all();

        return $this->paginator->paginate($products);
    }
}
