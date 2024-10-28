<?php

declare(strict_types=1);

namespace App\Virtual\Requests\Product\Update;

use OpenApi\Attributes as OA;

#[OA\Schema(
    title: 'Atualização de um produto via PUT',
    description: 'Modelo de atualização via método HTTP PUT de um produto',
    type: 'object',
)]
class UpdateProductVirtualPutRequest
{
    #[OA\Property(
        property: 'category_id',
        type: 'string',
        description: 'Id da categoria',
        example: '6e58a4cd-bf74-4f51-ad4f-9d8cac7f1705',
    )]
    public readonly string $category_id;

    #[OA\Property(
        property: 'name',
        type: 'string',
        description: 'Nome do produto',
        example: 'Coca-Cola',
    )]
    public readonly string $name;

    #[OA\Property(
        property: 'price',
        type: 'float',
        description: 'Preço do produto',
        example: '4.30',
    )]
    public readonly string $price;
}
