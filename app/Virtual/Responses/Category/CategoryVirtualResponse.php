<?php

declare(strict_types=1);

namespace App\Virtual\Responses\Category;

use OpenApi\Attributes as OA;

#[OA\Schema(
    description: 'Default response for category request (GET, POST, PUT, PATCH) requests',
    type: 'object',
    title: 'Category base response example',
)]
class CategoryVirtualResponse
{
    #[OA\Property(
        title: 'Id',
        description: 'The unique identifier of the category.',
        type: 'string',
        format: 'uuid',
    )]
    public string $id;

    #[OA\Property(
        property: 'name',
        type: 'string',
        description: 'The category name',
        example: 'Bebidas',
    )]
    public string $name;

    #[OA\Property(
        property: 'description',
        type: 'string',
        description: 'The category description',
        nullable: true,
        example: 'Tipos de bebidas alcoólicas e não alcoólicas'
    )]
    public ?string $description;

    #[OA\Property(
        title: 'Created at',
        description: 'The date and time when the category was created',
        type: 'string',
        format: 'date-time',
        example: '2024-10-27 23:00:00',
    )]
    public string $created_at;

    #[OA\Property(
        title: 'Updated at',
        description: 'The date and time when the category was updated',
        type: 'string',
        format: 'date-time',
        example: '2024-10-27 23:00:00',
    )]
    public string $updated_at;
}
