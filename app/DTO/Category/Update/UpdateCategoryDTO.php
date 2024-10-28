<?php

declare(strict_types=1);

namespace App\DTO\Category\Update;

use App\Contracts\DTO\Category\Update\UpdateCategoryDTOContract;
use App\DTO\BaseDTO;
use App\Exceptions\InvalidParameterException;
use App\Http\Requests\Category\Update\UpdateCategoryRequest;
use App\Messages\System\SystemMessage;

class UpdateCategoryDTO extends BaseDTO implements UpdateCategoryDTOContract
{
    public function __construct(
        public readonly string $id,
        public readonly ?string $name = null,
        public readonly ?string $description = null,
    ) {}

    public static function fromRequest(UpdateCategoryRequest $request, string $categoryId): UpdateCategoryDTO
    {
        $payload = clean($request->validated());

        $payload['id'] = $categoryId;

        return new self(...$payload);
    }

    public static function fromArray(array $payload): UpdateCategoryDTO
    {
        return new self(...clean($payload));
    }

    public function get(string $property): ?string
    {
        if (! property_exists($this, $property)) {
            throw new InvalidParameterException(SystemMessage::INVALID_PARAMETER);
        }

        return $this->$property;
    }
}
