<?php

declare(strict_types=1);

namespace App\Contracts\Services\Product\Find;

use App\Exceptions\InvalidParameterException;
use App\Exceptions\NotFoundException;
use App\Models\Product;

interface FindProductByIdServiceContract
{
    /**
     * @throws InvalidParameterException
     * @throws NotFoundException
     */
    public function handle(string $productId): Product;
}
