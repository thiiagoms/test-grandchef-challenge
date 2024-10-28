<?php

declare(strict_types=1);

namespace App\Virtual\Requests\Product\Register;

use OpenApi\Attributes as OA;

#[OA\Schema(
    description: 'Register Product request example',
    type: 'object',
    title: 'Register product request',
)]
class RegisterProductVirtualRequest
{
    #[OA\Property(
        property: 'category_id',
        type: 'string',
        description: 'The category id',
        example: 'uuid',
    )]
    public readonly string $category_id;

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
    public readonly string $price;
}
