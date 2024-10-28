<?php

declare(strict_types=1);

namespace App\Services\Product\Destroy;

use App\Contracts\Repositories\Product\ProductRepositoryContract;
use App\Contracts\Services\Product\Destroy\DestroyProductServiceContract;
use App\Contracts\Services\Product\Find\FindProductByIdServiceContract;

class DestroyProductService implements DestroyProductServiceContract
{
    public function __construct(
        private readonly FindProductByIdServiceContract $findProductByIdService,
        private readonly ProductRepositoryContract $productRepository
    ) {}

    public function handle(string $productId): bool
    {
        $this->findProductByIdService->handle($productId);

        return $this->productRepository->destroy($productId);
    }
}
