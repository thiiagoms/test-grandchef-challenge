<?php

declare(strict_types=1);

namespace App\Contracts\Services\Category\Destroy;

interface DestroyCategoryServiceContract
{
    /**
     * @throws InvalidParameterException
     * @throws NotFoundException
     */
    public function handle(string $categoryId): bool;
}
