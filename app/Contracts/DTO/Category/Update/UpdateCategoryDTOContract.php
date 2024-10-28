<?php

declare(strict_types=1);

namespace App\Contracts\DTO\Category\Update;

use App\Contracts\DTO\BaseDTOContract;
use App\DTO\Category\Update\UpdateCategoryDTO;
use App\Http\Requests\Category\Update\UpdateCategoryRequest;

interface UpdateCategoryDTOContract extends BaseDTOContract
{
    public static function fromRequest(UpdateCategoryRequest $request, string $categoryId): UpdateCategoryDTO;

    public static function fromArray(array $payload): UpdateCategoryDTO;

    public function get(string $property): ?string;
}
