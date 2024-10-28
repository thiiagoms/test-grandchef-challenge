<?php

declare(strict_types=1);

namespace App\Virtual\Responses\Category\Update;

use OpenApi\Attributes as OA;

#[OA\Schema(
    title: 'Exemplo de resposta para atualização de uma categoria via PATCH',
    description: 'Modelo de resposta referente à atualização via método HTTP PATCH de uma categoria',
    type: 'object',
)]
class UpdateCategoryVirtualPatchResponse
{
    #[OA\Property(
        title: 'Id',
        description: 'Id (uuid) da categoria',
        type: 'string',
        format: 'uuid',
    )]
    public string $id;

    #[OA\Property(
        property: 'name',
        type: 'string',
        description: 'Nome da categoria que foi atualizado',
        nullable: true,
        example: 'Coquetéis',
    )]
    public string $name;

    #[OA\Property(
        property: 'description',
        type: 'string',
        description: 'Descrição da categoria',
        example: 'Tipos de bebidas alcoólicas e não alcoólicas'
    )]
    public string $description;

    #[OA\Property(
        title: 'created_at',
        description: 'Data e hora em que a categoria foi criada',
        type: 'string',
        format: 'date-time',
        example: '2024-10-27 23:00:00',
    )]
    public string $created_at;

    #[OA\Property(
        title: 'updated at',
        description: 'Data e hora em que a categoria foi atualizada',
        type: 'string',
        format: 'date-time',
        example: '2024-10-27 23:00:00',
    )]
    public string $updated_at;
}
