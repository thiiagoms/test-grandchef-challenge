<?php

declare(strict_types=1);

namespace App\Contracts\DTO\Category\Register;

use App\Contracts\DTO\BaseDTOContract;
use App\DTO\Category\Register\RegisterCategoryDTO;
use App\Http\Requests\Category\Register\RegisterCategoryRequest;

interface RegisterCategoryDTOContract extends BaseDTOContract
{
    public static function fromRequest(RegisterCategoryRequest $request): RegisterCategoryDTO;

    public static function fromArray(array $payload): RegisterCategoryDTO;
}
