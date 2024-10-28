<?php

declare(strict_types=1);

namespace App\Services\Product\Register;

use App\Contracts\DTO\Product\Register\RegisterProductDTOContract;
use App\Contracts\Repositories\Product\ProductRepositoryContract;
use App\Contracts\Services\Category\Find\FindCategoryByIdServiceContract;
use App\Contracts\Services\Product\Register\RegisterProductServiceContract;
use App\Models\Product;

class RegisterProductService implements RegisterProductServiceContract
{
    public function __construct(
        private readonly FindCategoryByIdServiceContract $findCategoryByIdService,
        private readonly ProductRepositoryContract $productRepository
    ) {}

    public function handle(RegisterProductDTOContract $registerProductDTO): Product
    {
        $this->findCategoryByIdService->handle($registerProductDTO->get('category_id'));

        return $this->productRepository->create($registerProductDTO->toArray());
    }
}
