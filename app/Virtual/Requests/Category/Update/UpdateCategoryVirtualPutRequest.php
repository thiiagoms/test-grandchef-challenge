<?php

declare(strict_types=1);

namespace App\Virtual\Requests\Category\Update;

use OpenApi\Attributes as OA;

#[OA\Schema(
    title: 'Atualização de uma categoria via PUT',
    description: 'Modelo de atualização via método HTTP Put de uma categoria',
    type: 'object',
)]
class UpdateCategoryVirtualPutRequest
{
    #[OA\Property(
        property: 'name',
        type: 'string',
        description: 'Nome da categoria a ser atualizada',
        example: 'Coquetéis',
    )]
    public string $name;

    #[OA\Property(
        property: 'descriotion',
        type: 'string',
        description: 'Descrição da categoria a ser atualizada',
        example: 'Coquetéis elaborados com ingredientes variados, com ou sem adição de álcool.
        São uma opção saborosa e sofisticada, muitas vezes feita com frutas frescas, xaropes e refrigerantes,
        ideal para quem deseja uma bebida especial sem teor alcoólico',
    )]
    public string $description;
}
