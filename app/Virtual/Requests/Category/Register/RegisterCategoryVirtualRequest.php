<?php

declare(strict_types=1);

namespace App\Virtual\Requests\Category\Register;

use OpenApi\Attributes as OA;

#[OA\Schema(
    description: 'Register Category request example',
    type: 'object',
    title: 'Register category request',
)]
class RegisterCategoryVirtualRequest
{
    #[OA\Property(
        property: 'name',
        type: 'string',
        description: 'The category name',
        example: 'Bebidas',
    )]
    public readonly string $name;

    #[OA\Property(
        property: 'description',
        type: 'string',
        description: 'The category description',
        nullable: true,
        example: 'Tipos de bebidas alcoólicas e não alcoólicas'
    )]
    public readonly ?string $description;
}
