<?php

declare(strict_types=1);

namespace App\Contracts\Services\Category\Update;

use App\Contracts\DTO\Category\Update\UpdateCategoryDTOContract;
use App\Exceptions\InvalidParameterException;
use App\Exceptions\NotFoundException;
use App\Models\Category;

interface UpdateCategoryServiceContract
{
    /**
     * @throws InvalidParameterException
     * @throws NotFoundException
     */
    public function handle(UpdateCategoryDTOContract $categoryDTO): Category;
}
