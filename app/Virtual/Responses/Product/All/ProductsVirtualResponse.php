<?php

declare(strict_types=1);

namespace App\Virtual\Responses\Product\All;

use OpenApi\Attributes as OA;

#[OA\Schema(
    description: 'Default response for register product request',
    type: 'object',
    title: 'Product created response example',
)]
class ProductsVirtualResponse
{
    #[OA\Property(
        title: 'Id',
        description: 'The unique identifier of the product.',
        type: 'string',
        example: 'd17b2196-e47c-451c-afc2-39ae2f4da995',
    )]
    public readonly string $id;

    #[OA\Property(
        property: 'name',
        type: 'string',
        description: 'The product name',
        example: 'Água',
    )]
    public readonly string $name;

    #[OA\Property(
        property: 'price',
        type: 'float',
        description: 'The product price',
        example: '3.50',
    )]
    public readonly float $price;
}
