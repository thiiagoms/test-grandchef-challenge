<?php

declare(strict_types=1);

namespace App\Services\Category\Register;

use App\Contracts\DTO\Category\Register\RegisterCategoryDTOContract;
use App\Contracts\Repositories\Category\CategoryRepositoryContract;
use App\Contracts\Services\Category\Register\RegisterCategoryServiceContract;
use App\Models\Category;

class RegisterCategoryService implements RegisterCategoryServiceContract
{
    public function __construct(private readonly CategoryRepositoryContract $categoryRepository) {}

    public function handle(RegisterCategoryDTOContract $categoryDTO): Category
    {
        return $this->categoryRepository->create($categoryDTO->toArray());
    }
}
