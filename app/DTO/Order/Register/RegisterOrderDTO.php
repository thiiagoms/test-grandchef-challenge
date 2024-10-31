<?php

declare(strict_types=1);

namespace App\DTO\Order\Register;

use App\Contracts\DTO\Order\Register\RegisterOrderDTOContract;
use App\Exceptions\InvalidParameterException;
use App\Messages\System\SystemMessage;

class RegisterOrderDTO implements RegisterOrderDTOContract
{
    public function __construct(
        public readonly string $product_id,
        public readonly int $quantity,
        public readonly float $price
    ) {}

    public static function fromArray(array $payload): RegisterOrderDTO
    {
        $payload = clean($payload);

        $payload['price'] = (float) $payload['price'];

        $payload['quantity'] = (int) $payload['quantity'];

        return new self(...$payload);
    }

    public function get(string $property): ?array
    {
        if (! property_exists($this, $property)) {
            throw new InvalidParameterException(SystemMessage::INVALID_PARAMETER);
        }

        return $this->$property;
    }
}
