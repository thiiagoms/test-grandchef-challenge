<?php

declare(strict_types=1);

namespace App\DTO\Product\Register;

use App\Contracts\DTO\Product\Register\RegisterProductDTOContract;
use App\DTO\BaseDTO;
use App\Exceptions\InvalidParameterException;
use App\Http\Requests\Product\Register\RegisterProductRequest;
use App\Messages\System\SystemMessage;

class RegisterProductDTO extends BaseDTO implements RegisterProductDTOContract
{
    public function __construct(
        public readonly string $category_id,
        public readonly string $name,
        public readonly float $price
    ) {}

    public static function fromRequest(RegisterProductRequest $request): RegisterProductDTO
    {
        $payload = clean($request->validated());

        $payload['price'] = (float) $payload['price'];

        return new self(...$payload);
    }

    public static function fromArray(array $payload): RegisterProductDTO
    {
        $payload['price'] = (float) $payload['price'];

        return new self(...$payload);
    }

    public function get(string $property): string|float
    {
        if (! property_exists($this, $property)) {
            throw new InvalidParameterException(SystemMessage::INVALID_PARAMETER);
        }

        return $this->$property;
    }
}
