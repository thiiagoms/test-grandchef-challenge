<?php

declare(strict_types=1);

namespace App\Services\Category\Find;

use App\Contracts\Repositories\Category\CategoryRepositoryContract;
use App\Contracts\Services\Category\Find\FindCategoryByIdServiceContract;
use App\Contracts\Validators\UuidValidatorContract;
use App\Exceptions\NotFoundException;
use App\Messages\System\SystemMessage;
use App\Models\Category;

class FindCategoryByIdService implements FindCategoryByIdServiceContract
{
    public function __construct(
        private readonly UuidValidatorContract $uuidValidator,
        private readonly CategoryRepositoryContract $categoryRepository
    ) {}

    private function checkCategoryExists(?Category $category): void
    {
        throw_if($category === null, new NotFoundException(SystemMessage::RESOURCE_NOT_FOUND));
    }

    public function handle(string $id): Category
    {
        $this->uuidValidator->checkUuidIsValid($id);

        $category = $this->categoryRepository->find($id);

        $this->checkCategoryExists($category);

        return $category;
    }
}
