<?php

declare(strict_types=1);

namespace App\Contracts\Services\Product\Update;

use App\Contracts\DTO\Product\Update\UpdateProductDTOContract;
use App\Exceptions\InvalidParameterException;
use App\Exceptions\NotFoundException;
use App\Models\Product;

interface UpdateProductServiceContract
{
    /**
     * @throws InvalidParameterException
     * @throws NotFoundException
     */
    public function handle(UpdateProductDTOContract $updateProductDTO): Product;
}
