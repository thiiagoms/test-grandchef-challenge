<?php

declare(strict_types=1);

namespace App\Services\Category\Destroy;

use App\Contracts\Repositories\Category\CategoryRepositoryContract;
use App\Contracts\Services\Category\Destroy\DestroyCategoryServiceContract;
use App\Contracts\Services\Category\Find\FindCategoryByIdServiceContract;

class DestroyCategoryService implements DestroyCategoryServiceContract
{
    public function __construct(
        private readonly FindCategoryByIdServiceContract $findCategoryByIdService,
        private readonly CategoryRepositoryContract $categoryRepository
    ) {}

    public function handle(string $categoryId): bool
    {
        $this->findCategoryByIdService->handle($categoryId);

        return $this->categoryRepository->destroy($categoryId);
    }
}
