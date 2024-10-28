<?php

declare(strict_types=1);

namespace App\DTO\Category\Register;

use App\Contracts\DTO\Category\Register\RegisterCategoryDTOContract;
use App\DTO\BaseDTO;
use App\Http\Requests\Category\Register\RegisterCategoryRequest;

class RegisterCategoryDTO extends BaseDTO implements RegisterCategoryDTOContract
{
    public function __construct(public readonly string $name, public readonly ?string $description = null) {}

    public static function fromRequest(RegisterCategoryRequest $request): RegisterCategoryDTO
    {
        $payload = clean($request->validated());

        return new self(...$payload);
    }

    public static function fromArray(array $payload): RegisterCategoryDTO
    {
        $payload = clean($payload);

        return new self(...$payload);
    }
}
