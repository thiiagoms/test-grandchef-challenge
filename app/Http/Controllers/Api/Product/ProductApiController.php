<?php

namespace App\Http\Controllers\Api\Product;

use App\DTO\Product\Register\RegisterProductDTO;
use App\DTO\Product\Update\UpdateProductDTO;
use App\Http\Requests\Product\Register\RegisterProductRequest;
use App\Http\Requests\Product\Update\UpdateProductRequest;
use App\Http\Resources\Product\ProductListResource;
use App\Http\Resources\Product\ProductResource;
use App\Http\Resources\Product\ProductsResource;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use OpenApi\Attributes as OA;
use OpenApi\Attributes\JsonContent;

class ProductApiController extends BaseProductApiController
{
    #[OA\Get(
        path: '/api/products',
        tags: ['Products'],
        summary: 'Retorna todos os produtos paginados',
        description: 'Retorna todos os dados das produtos existentes na base de dados paginadas com 10 itens por página.',
        responses: [
            new OA\Response(
                response: 200,
                description: 'Sucesso na resposta',
                content: new JsonContent(
                    type: 'array',
                    items: new OA\Items(
                        type: 'object',
                        ref: '#/components/schemas/ProductsVirtualResponse'
                    )
                ),
            ),
        ]
    )]
    public function index(): AnonymousResourceCollection
    {
        $products = $this->getAllProductsService->handle();

        return ProductsResource::collection($products);
    }

    #[OA\Post(
        path: '/api/products',
        tags: ['Products'],
        summary: 'Cadastra um novo produto relacionando-o à categoria.',
        description: 'Cadastra um novo produto e retorna os dados do produto que foi cadastrado com sucesso.',
        requestBody: new OA\RequestBody(
            required: true,
            content: new JsonContent(
                ref: '#/components/schemas/RegisterProductVirtualRequest'
            )
        ),
        responses: [
            new OA\Response(
                response: 201,
                description: 'Retorna os dados do produto cadastrado.',
                content: new JsonContent(
                    type: 'object',
                    properties: [
                        new OA\Property(
                            property: 'data',
                            type: 'array',
                            items: new OA\Items(
                                type: 'object',
                                ref: '#/components/schemas/ProductCreatedVirtualResponse'
                            )
                        ),
                    ]
                )
            ),
            new OA\Response(
                response: 400,
                description: 'O servidor não conseguiu processar a requisição por motivos da requisição conter dados inválidos.'
            ),
        ]
    )]
    public function store(RegisterProductRequest $request): ProductResource
    {
        $productDTO = RegisterProductDTO::fromRequest($request);

        $product = $this->registerProductService->handle($productDTO);

        return ProductResource::make($product);
    }

    #[OA\Get(
        path: '/api/products/{id}',
        tags: ['Products'],
        summary: 'Retorna os dados do produto.',
        description: 'Retorna os dados do produto se o produto existir na base de dados.',
        parameters: [
            new OA\Parameter(
                name: 'id',
                in: 'path',
                description: 'Id (uuid) do produto a ser exibido.',
                required: true,
                example: 'd17b2196-e47c-451c-afc2-39ae2f4da995',
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
                    type: 'object',
                    properties: [
                        new OA\Property(
                            property: 'data',
                            type: 'array',
                            items: new OA\Items(
                                type: 'object',
                                ref: '#/components/schemas/ProductListVirtualResponse'
                            )
                        ),
                    ]
                )
            ),
            new OA\Response(
                response: 404,
                description: 'O servidor conseguiu processar a requisição porém não encontrou a categoria com o id informado.'
            ),
        ]
    )]
    public function show(Product $product): ProductListResource
    {
        return ProductListResource::make($product);
    }

    #[OA\Put(
        path: '/api/products/{id}',
        tags: ['Products'],
        summary: 'Atualização completa dos dados de um produto',
        description: 'Atualização completa dos dados do produto se a produto existir na base de dados.',
        parameters: [
            new OA\Parameter(
                name: 'id',
                in: 'path',
                description: 'Id (uuid) do produto a ser atualizado.',
                required: true,
                example: 'd17b2196-e47c-451c-afc2-39ae2f4da995',
                schema: new OA\Schema(
                    type: 'string'
                )
            ),
        ],
        requestBody: new OA\RequestBody(
            description: 'Dados do produto à serem atualizados',
            required: true,
            content: new JsonContent(
                ref: '#/components/schemas/UpdateProductVirtualPutRequest'
            )
        ),
        responses: [
            new OA\Response(
                response: 200,
                description: 'Retorna os dados do produto atualizado.',
                content: new JsonContent(
                    type: 'object',
                    properties: [
                        new OA\Property(
                            property: 'data',
                            type: 'array',
                            items: new OA\Items(
                                type: 'object',
                                ref: '#/components/schemas/ProductUpdatedVirtualPutResponse'
                            )
                        ),
                    ]
                )
            ),
            new OA\Response(
                response: 400,
                description: 'O servidor não conseguiu processar a requisição por motivos da requisição conter dados inválidos.'
            ),
            new OA\Response(
                response: 404,
                description: 'O servidor conseguiu processar a requisição porém não encontrou a categoria com o id informado.'
            ),
        ]
    )]
    #[OA\Patch(
        path: '/api/products/{id}',
        tags: ['Products'],
        summary: 'Atualização completa dos dados de um produto',
        description: 'Atualização completa dos dados do produto se a produto existir na base de dados.',
        parameters: [
            new OA\Parameter(
                name: 'id',
                in: 'path',
                description: 'Id (uuid) do produto a ser atualizado.',
                required: true,
                example: 'd17b2196-e47c-451c-afc2-39ae2f4da995',
                schema: new OA\Schema(
                    type: 'string'
                )
            ),
        ],
        requestBody: new OA\RequestBody(
            description: 'Dados do produto à serem atualizados',
            required: true,
            content: new JsonContent(
                ref: '#/components/schemas/UpdateProductVirtualPatchRequest'
            )
        ),
        responses: [
            new OA\Response(
                response: 200,
                description: 'Retorna os dados do produto atualizado.',
                content: new JsonContent(
                    type: 'object',
                    properties: [
                        new OA\Property(
                            property: 'data',
                            type: 'array',
                            items: new OA\Items(
                                type: 'object',
                                ref: '#/components/schemas/ProductUpdatedVirtualPatchResponse'
                            )
                        ),
                    ]
                )
            ),
            new OA\Response(
                response: 400,
                description: 'O servidor não conseguiu processar a requisição por motivos da requisição conter dados inválidos.'
            ),
            new OA\Response(
                response: 404,
                description: 'O servidor conseguiu processar a requisição porém não encontrou o produto com o id informado.'
            ),
        ]
    )]
    public function update(UpdateProductRequest $request, Product $product): ProductResource
    {
        $productDTO = UpdateProductDTO::fromRequest($request, $product->id);

        $product = $this->updateProductService->handle($productDTO);

        return ProductResource::make($product);
    }

    #[OA\Delete(
        path: '/api/products/{id}',
        tags: ['Products'],
        summary: 'Deleta um produto da base de dados',
        description: 'Deleta os dados de um produto da base de dados se o produto existir na base de dados.',
        parameters: [
            new OA\Parameter(
                name: 'id',
                in: 'path',
                description: 'Id (uuid) do produto a ser deletado.',
                required: true,
                schema: new OA\Schema(
                    type: 'string'
                ),
                example: 'd17b2196-e47c-451c-afc2-39ae2f4da995'
            ),
        ],
        responses: [
            new OA\Response(
                response: 204,
                description: 'Sucesso na resposta'
            ),
            new OA\Response(
                response: 404,
                description: 'O servidor conseguiu processar a requisição porém não encontrou o produto com o id informado.'
            ),
        ]
    )]
    public function destroy(Product $product): JsonResponse
    {
        $this->destroyProductService->handle($product->id);

        return response()->json([], Response::HTTP_NO_CONTENT);
    }
}
