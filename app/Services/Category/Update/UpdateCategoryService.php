<?php

declare(strict_types=1);

namespace App\Services\Category\Update;

use App\Contracts\DTO\Category\Update\UpdateCategoryDTOContract;
use App\Contracts\Repositories\Category\CategoryRepositoryContract;
use App\Contracts\Services\Category\Find\FindCategoryByIdServiceContract;
use App\Contracts\Services\Category\Update\UpdateCategoryServiceContract;
use App\Models\Category;

class UpdateCategoryService implements UpdateCategoryServiceContract
{
    public function __construct(
        private readonly FindCategoryByIdServiceContract $findCategoryByIdService,
        private readonly CategoryRepositoryContract $categoryRepository
    ) {}

    /**
     * @throws InvalidParameterException
     * @throws NotFoundException
     */
    public function handle(UpdateCategoryDTOContract $categoryDTO): Category
    {
        $this->findCategoryByIdService->handle($categoryDTO->get('id'));

        $this->categoryRepository->update($categoryDTO->get('id'), removeEmpty($categoryDTO->toArray()));

        return $this->findCategoryByIdService->handle($categoryDTO->get('id'));
    }
}
