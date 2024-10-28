<?php

declare(strict_types=1);

namespace App\Services\Product\Update;

use App\Contracts\DTO\Product\Update\UpdateProductDTOContract;
use App\Contracts\Repositories\Product\ProductRepositoryContract;
use App\Contracts\Services\Category\Find\FindCategoryByIdServiceContract;
use App\Contracts\Services\Product\Find\FindProductByIdServiceContract;
use App\Contracts\Services\Product\Update\UpdateProductServiceContract;
use App\Models\Product;

class UpdateProductService implements UpdateProductServiceContract
{
    public function __construct(
        private readonly FindProductByIdServiceContract $findProductByIdService,
        private readonly FindCategoryByIdServiceContract $findCategoryByIdService,
        private readonly ProductRepositoryContract $productRepository
    ) {}

    private function checkProductExists(UpdateProductDTOContract $updateProductDTO): void
    {
        $this->findProductByIdService->handle($updateProductDTO->get('id'));
    }

    private function checkCategoryExists(UpdateProductDTOContract $updateProductDTO): void
    {
        $this->findCategoryByIdService->handle($updateProductDTO->get('category_id'));
    }

    public function handle(UpdateProductDTOContract $updateProductDTO): Product
    {
        $this->checkProductExists($updateProductDTO);

        $this->checkCategoryExists($updateProductDTO);

        $this->productRepository->update($updateProductDTO->get('id'), removeEmpty($updateProductDTO->toArray()));

        return $this->findProductByIdService->handle($updateProductDTO->get('id'));
    }
}
