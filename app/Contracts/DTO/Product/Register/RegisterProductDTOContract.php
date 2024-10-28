<?php

declare(strict_types=1);

namespace App\Contracts\DTO\Product\Register;

use App\Contracts\DTO\BaseDTOContract;
use App\DTO\Product\Register\RegisterProductDTO;
use App\Http\Requests\Product\Register\RegisterProductRequest;

interface RegisterProductDTOContract extends BaseDTOContract
{
    public static function fromRequest(RegisterProductRequest $request): RegisterProductDTO;

    public static function fromArray(array $payload): RegisterProductDTO;

    public function get(string $property): string|float;
}
