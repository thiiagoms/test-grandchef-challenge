<?php

declare(strict_types=1);

namespace App\Contracts\DTO\Order\Register;

use App\DTO\Order\Register\RegisterOrderDTO;

interface RegisterOrderDTOContract
{
    public static function fromArray(array $payload): RegisterOrderDTO;

    public function get(string $property): ?array;
}
