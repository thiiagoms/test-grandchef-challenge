<?php

declare(strict_types=1);

namespace App\DTO\Product\Update;

use App\Contracts\DTO\Product\Update\UpdateProductDTOContract;
use App\DTO\BaseDTO;
use App\Exceptions\InvalidParameterException;
use App\Http\Requests\Product\Update\UpdateProductRequest;
use App\Messages\System\SystemMessage;

class UpdateProductDTO extends BaseDTO implements UpdateProductDTOContract
{
    public function __construct(
        public readonly string $id,
        public readonly string $category_id,
        public readonly ?string $name = null,
        public readonly ?float $price = null
    ) {}

    public static function fromRequest(UpdateProductRequest $request, string $productId): UpdateProductDTO
    {
        $payload = clean($request->validated());

        if (isset($payload['price'])) {
            $payload['price'] = (float) $payload['price'];
        }

        $payload['id'] = clean($productId);

        return new UpdateProductDTO(...$payload);
    }

    public static function fromArray(array $payload): UpdateProductDTO
    {
        $payload = clean($payload);

        if (isset($payload['price'])) {
            $payload['price'] = (float) $payload['price'];
        }

        return new UpdateProductDTO(...$payload);
    }

    public function get(string $property): string|float|null
    {
        if (! property_exists($this, $property)) {
            throw new InvalidParameterException(SystemMessage::INVALID_PARAMETER);
        }

        return $this->$property;
    }
}
