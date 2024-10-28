<?php

declare(strict_types=1);

namespace App\Contracts\DTO\Product\Update;

use App\Contracts\DTO\BaseDTOContract;
use App\DTO\Product\Update\UpdateProductDTO;
use App\Http\Requests\Product\Update\UpdateProductRequest;

interface UpdateProductDTOContract extends BaseDTOContract
{
    public static function fromRequest(UpdateProductRequest $request, string $productId): UpdateProductDTO;

    public static function fromArray(array $payload): UpdateProductDTO;

    public function get(string $property): string|float|null;
}
