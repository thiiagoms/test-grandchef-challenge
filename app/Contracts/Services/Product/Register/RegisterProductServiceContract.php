<?php

declare(strict_types=1);

namespace App\Contracts\Services\Product\Register;

use App\Contracts\DTO\Product\Register\RegisterProductDTOContract;
use App\Exceptions\InvalidParameterException;
use App\Exceptions\NotFoundException;
use App\Models\Product;

interface RegisterProductServiceContract
{
    /**
     * @throws InvalidParameterException
     * @throws NotFoundException
     */
    public function handle(RegisterProductDTOContract $registerProductDTO): Product;
}
