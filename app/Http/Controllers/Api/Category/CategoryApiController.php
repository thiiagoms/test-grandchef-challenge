<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Category;

use App\DTO\Category\Register\RegisterCategoryDTO;
use App\DTO\Category\Update\UpdateCategoryDTO;
use App\Http\Requests\Category\Register\RegisterCategoryRequest;
use App\Http\Requests\Category\Update\UpdateCategoryRequest;
use App\Http\Resources\Category\CategoriesResource;
use App\Http\Resources\Category\CategoryResource;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use OpenApi\Attributes as OA;
use OpenApi\Attributes\JsonContent;

class CategoryApiController extends BaseCategoryApiController
{
    #[OA\Get(
        path: '/api/categories',
        tags: ['Categories'],
        summary: 'Retorna todas as categorias paginadas',
        description: 'Retorna todos os dados das categorias existentes na base de dados paginadas com 10 itens por página.',
        responses: [
            new OA\Response(
                response: 200,
                description: 'Sucesso na resposta',
                content: new JsonContent(
                    type: 'array',
                    items: new OA\Items(
                        type: 'object',
                        ref: '#/components/schemas/CategoryVirtualResponse'
                    )
                ),
            ),
        ]
    )]
    public function index(): AnonymousResourceCollection
    {
        $categories = $this->categoryAllService->handle();

        return CategoriesResource::collection($categories);
    }

    #[OA\Post(
        path: '/api/categories',
        tags: ['Categories'],
        summary: 'Cadastra uma nova categoria',
        description: 'Cadastra uma nova categoria e retorna os dados da categoria que foram cadastrados com sucesso.',
        requestBody: new OA\RequestBody(
            description: 'Dados da categoria para serem cadastrados.',
            required: true,
            content: new JsonContent(
                ref: '#/components/schemas/RegisterCategoryVirtualRequest'
            )
        ),
        responses: [
            new OA\Response(
                response: 201,
                description: 'Sucesso na resposta',
                content: new JsonContent(
                    type: 'array',
                    items: new OA\Items(
                        type: 'object',
                        ref: '#/components/schemas/CategoryVirtualResponse'
                    )
                )
            ),
            new OA\Response(
                response: 400,
                description: 'O servidor não conseguiu processar a requisição por motivos da requisição conter dados inválidos.'
            ),
        ]
    )]
    public function store(RegisterCategoryRequest $request): CategoryResource
    {
        $category = RegisterCategoryDTO::fromRequest($request);

        $category = $this->registerCategoryService->handle($category);

        return CategoryResource::make($category);
    }

    #[OA\Get(
        path: '/api/categories/{id}',
        tags: ['Categories'],
        summary: 'Retorna os dados da categoria',
        description: 'Retorna os dados da categoria se a categoria existir na base de dados.',
        parameters: [
            new OA\Parameter(
                name: 'id',
                in: 'path',
                description: 'Id (uuid) da categoria a ser exibida.',
                required: true,
                example: '3fa85f64-5717-4562-b3fc-2c963f66afa6',
                schema: new OA\Schema(
                    type: 'string'
                )
            ),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Sucesso na resposta',
                content: new JsonContent(
                    type: 'array',
                    items: new OA\Items(
                        type: 'object',
                        ref: '#/components/schemas/CategoryVirtualResponse'
                    )
                )
            ),
            new OA\Response(
                response: 404,
                description: 'O servidor conseguiu processar a requisição porém não encontrou a categoria com o id informado.'
            ),
        ]
    )]
    public function show(Category $category): CategoryResource
    {
        return CategoryResource::make($category);
    }

    #[OA\Patch(
        path: '/api/categories/{id}',
        tags: ['Categories'],
        summary: 'Atualização parcial dos dados de uma categoria',
        description: 'Atualização parcial dos dados de uma categoria e retorna os dados da categoria que foram atualizados com sucesso.',
        parameters: [
            new OA\Parameter(
                name: 'id',
                in: 'path',
                description: 'Id (uuid) da categoria a ser atualizada.',
                required: true,
                example: '3fa85f64-5717-4562-b3fc-2c963f66afa6',
                schema: new OA\Schema(
                    type: 'string'
                )
            ),
        ],
        requestBody: new OA\RequestBody(
            description: 'Dados da categoria à serem atualizados',
            required: true,
            content: new JsonContent(
                ref: '#/components/schemas/UpdateCategoryVirtualPatchRequest'
            )
        ),
        responses: [
            new OA\Response(
                response: 200,
                description: 'Sucesso na resposta',
                content: new JsonContent(
                    type: 'array',
                    items: new OA\Items(
                        type: 'object',
                        ref: '#/components/schemas/UpdateCategoryVirtualPatchResponse'
                    )
                )
            ),
            new OA\Response(
                response: 400,
                description: 'The server could not process the request due to invalid input.'
            ),
            new OA\Response(
                response: 404,
                description: 'O servidor não conseguiu processar a requisição por motivos da requisição conter dados inválidos.'
            ),
        ]
    )]
    #[OA\Put(
        path: '/api/categories/{id}',
        tags: ['Categories'],
        summary: 'Atualização parcial dos dados de uma categoria',
        description: 'Atualização parcial dos dados da categoria se a categoria existir na base de dados.',
        parameters: [
            new OA\Parameter(
                name: 'id',
                in: 'path',
                description: 'Id (uuid) da categoria a ser atualizada.',
                required: true,
                schema: new OA\Schema(
                    type: 'string'
                )
            ),
        ],
        requestBody: new OA\RequestBody(
            description: 'Dados da categoria à serem atualizados',
            required: true,
            content: new JsonContent(
                ref: '#/components/schemas/UpdateCategoryVirtualPutRequest'
            )
        ),
        responses: [
            new OA\Response(
                response: 200,
                description: 'Sucesso na resposta',
                content: new JsonContent(
                    type: 'array',
                    items: new OA\Items(
                        type: 'object',
                        ref: '#/components/schemas/UpdateCategoryVirtualPutResponse'
                    )
                )
            ),
            new OA\Response(
                response: 400,
                description: 'O servidor não conseguiu processar a requisição por motivos da requisição possuir dados inválidos.'
            ),
            new OA\Response(
                response: 404,
                description: 'O servidor conseguiu processar a requisição porém não encontrou a categoria com o id informado.'
            ),
        ]
    )]
    public function update(UpdateCategoryRequest $request, Category $category): CategoryResource
    {
        $categoryDTO = UpdateCategoryDTO::fromRequest($request, $category->id);

        $category = $this->updateCategoryService->handle($categoryDTO);

        return CategoryResource::make($category);
    }

    #[OA\Delete(
        path: '/api/categories/{id}',
        tags: ['Categories'],
        summary: 'Deleta uma categoria da base de dados',
        description: 'Deleta os dados de uma categoria da base de dados se a categoria existir na base de dados.',
        parameters: [
            new OA\Parameter(
                name: 'id',
                in: 'path',
                description: 'Id (uuid) da categoria a ser deletada.',
                required: true,
                schema: new OA\Schema(
                    type: 'string'
                )
            ),
        ],
        responses: [
            new OA\Response(
                response: 204,
                description: 'Sucesso na resposta'
            ),
            new OA\Response(
                response: 404,
                description: 'O servidor conseguiu processar a requisição porém não encontrou a categoria com o id informado.'
            ),
        ]
    )]
    public function destroy(Category $category): JsonResponse
    {
        $this->destroyCategoryService->handle($category->id);

        return response()->json([], Response::HTTP_NO_CONTENT);
    }
}
