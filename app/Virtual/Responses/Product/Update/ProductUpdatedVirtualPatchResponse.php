<?php

declare(strict_types=1);

namespace App\Virtual\Responses\Product\Update;

use OpenApi\Attributes as OA;

#[OA\Schema(
    description: 'Exemplo de resposta para atualização de um produto via PATCH',
    type: 'object',
    title: 'Modelo de resposta referente à atualização via método HTTP PATCH de um produto',
)]
class ProductUpdatedVirtualPatchResponse
{
    #[OA\Property(
        title: 'Id',
        description: 'The unique identifier of the product.',
        type: 'string',
        example: 'd17b2196-e47c-451c-afc2-39ae2f4da995',
    )]
    public readonly string $id;

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
        description: 'The product name',
        example: 'Coca-Cola',
    )]
    public readonly string $name;

    #[OA\Property(
        property: 'price',
        type: 'float',
        description: 'The product price',
        example: '3.50',
    )]
    public readonly float $price;

    #[OA\Property(
        title: 'Created at',
        description: 'The date and time when the category was created',
        type: 'string',
        format: 'date-time',
        example: '2024-10-27 23:00:00',
    )]
    public readonly string $created_at;

    #[OA\Property(
        title: 'Updated at',
        description: 'The date and time when the category was updated',
        type: 'string',
        format: 'date-time',
        example: '2024-10-27 23:00:00',
    )]
    public readonly string $updated_at;
}
