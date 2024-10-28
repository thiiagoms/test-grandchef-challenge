<?php

declare(strict_types=1);

namespace App\Contracts\Services\Product\Destroy;

use App\Exceptions\InvalidParameterException;
use App\Exceptions\NotFoundException;

interface DestroyProductServiceContract
{
    /**
     * @throws InvalidParameterException
     * @throws NotFoundException
     */
    public function handle(string $productId): bool;
}
