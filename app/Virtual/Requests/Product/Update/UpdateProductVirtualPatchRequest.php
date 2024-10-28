<?php

declare(strict_types=1);

namespace App\Virtual\Requests\Product\Update;

use OpenApi\Attributes as OA;

#[OA\Schema(
    title: 'Atualização de um produto via PATCH',
    description: 'Modelo de atualização via método HTTP PATCH de um produto',
    type: 'object',
)]
class UpdateProductVirtualPatchRequest
{
    #[OA\Property(
        property: 'category_id',
        type: 'string',
        description: 'The category id',
        format: 'uuid',
    )]
    public readonly string $category_id;

    #[OA\Property(
        property: 'name',
        type: 'string',
        description: 'Nome do produto',
        example: 'Coca-Cola',
    )]
    public readonly string $name;
}
