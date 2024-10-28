<?php

declare(strict_types=1);

namespace App\Virtual\Requests\Category\Update;

use OpenApi\Attributes as OA;

#[OA\Schema(
    title: 'Exemplo de requisição para atualização de uma categoria via PATCH',
    description: 'Modelo de request referente à atualização via método HTTP Patch de uma categoria',
    type: 'object',
)]
class UpdateCategoryVirtualPatchRequest
{
    #[OA\Property(
        property: 'name',
        type: 'string',
        description: 'Nome da categoria atualizado',
        nullable: true,
        example: 'Coquetéis',
    )]
    public ?string $name;
}
