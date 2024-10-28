<?php

declare(strict_types=1);

namespace App\Contracts\Services\Category\Find;

use App\Exceptions\InvalidParameterException;
use App\Models\Category;

interface FindCategoryByIdServiceContract
{
    /**
     * @throws InvalidParameterException
     * @throws NotFoundException
     */
    public function handle(string $id): Category;
}
