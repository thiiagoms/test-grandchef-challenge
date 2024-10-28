<?php

declare(strict_types=1);

namespace App\Services\Product\Find;

use App\Contracts\Repositories\Product\ProductRepositoryContract;
use App\Contracts\Services\Product\Find\FindProductByIdServiceContract;
use App\Contracts\Validators\UuidValidatorContract;
use App\Exceptions\NotFoundException;
use App\Messages\System\SystemMessage;
use App\Models\Product;

class FindProductByIdService implements FindProductByIdServiceContract
{
    public function __construct(
        private readonly UuidValidatorContract $uuidValidator,
        private readonly ProductRepositoryContract $productRepository
    ) {}

    private function checkProductExists(?Product $product): void
    {
        throw_if($product === null, new NotFoundException(SystemMessage::RESOURCE_NOT_FOUND));
    }

    public function handle(string $productId): Product
    {
        $this->uuidValidator->checkUuidIsValid($productId);

        $product = $this->productRepository->find($productId);

        $this->checkProductExists($product);

        return $product;
    }
}
