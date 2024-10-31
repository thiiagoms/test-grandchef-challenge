<?php

use App\Messages\Order\OrderProductPayloadMessage;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Testing\Fluent\AssertableJson;
use Illuminate\Testing\TestResponse;

it('should return product key is required message when product key does not exists in order request', fn (): TestResponse => $this
    ->postJson(ORDER_ENDPOINT, [])
    ->assertBadRequest()
    ->asserTJson(fn (AssertableJson $json): AssertableJson => $json
        ->hasAll([
            'error',
            'error.products',
            'error.products.0',
        ])
        ->whereAllType([
            'error' => 'array',
            'error.products' => 'array',
            'error.products.0' => 'string',
        ])
        ->where('error.products.0', OrderProductPayloadMessage::ORDER_PRODUCT_KEY_IS_REQUIRED)
    )
);

it('should return product key must be an array message when product key is not an array in order request', fn (): TestResponse => $this
    ->postJson(ORDER_ENDPOINT, ['products' => 1])
    ->assertBadRequest()
    ->asserTJson(fn (AssertableJson $json): AssertableJson => $json
        ->hasAll([
            'error',
            'error.products',
            'error.products.0',
        ])
        ->whereAllType([
            'error' => 'array',
            'error.products' => 'array',
            'error.products.0' => 'string',
        ])
        ->where('error.products.0', OrderProductPayloadMessage::ORDER_PRODUCT_KEY_MUST_BE_VALID_ARRAY)
    )
);

it('should return product id key, price key and quantity key are required message when order request does not have required keys', function (): void {

    $response = $this
        ->postJson(ORDER_ENDPOINT, ['products' => [[]]])
        ->assertBadRequest()
        ->json();

    $messages = [
        'products.0.product_id' => OrderProductPayloadMessage::ORDER_PRODUCT_ID_KEY_IS_REQUIRED,
        'products.0.price' => OrderProductPayloadMessage::ORDER_PRODUCT_PRICE_KEY_IS_REQUIRED,
        'products.0.quantity' => OrderProductPayloadMessage::ORDER_PRODUCT_QUANTITY_KEY_IS_REQUIRED,
    ];

    foreach ($messages as $key => $message) {

        $this->assertArrayHasKey('error', $response);
        $this->assertArrayHasKey($key, $response['error']);

        $this->assertEquals($message, $response['error'][$key][0]);
    }
});

it('should return product id key is required message when product is key doe not exists inside order request', function (): void {

    $payload = ['products' => [['quantity' => 2, 'price' => '3.15']]];

    $response = $this
        ->postJson(ORDER_ENDPOINT, $payload)
        ->assertBadRequest()
        ->json();

    $this->assertArrayHasKey('error', $response);
    $this->assertArrayHasKey('products.0.product_id', $response['error']);

    $errorMessage = $response['error']['products.0.product_id'][0];

    $this->assertEquals($errorMessage, OrderProductPayloadMessage::ORDER_PRODUCT_ID_KEY_IS_REQUIRED);
});

it('should return product is does not exists in database message when product id does not exists in database', function (): void {

    $payload = ['products' => [['product_id' => fake()->uuid(), 'quantity' => 2, 'price' => '3.15']]];

    $response = $this
        ->postJson(ORDER_ENDPOINT, $payload)
        ->assertBadRequest()
        ->json();

    $this->assertArrayHasKey('error', $response);
    $this->assertArrayHasKey('products.0.product_id', $response['error']);

    $errorMessage = $response['error']['products.0.product_id'][0];

    $this->assertEquals($errorMessage, OrderProductPayloadMessage::ORDER_PRODUCT_ID_DOEST_NOT_EXISTS_IN_DATABASE);
});

it('should return product price key is required message when product price does not exists inside order request', function (): void {

    $product = Product::factory()->createOne();

    $payload = ['products' => [['product_id' => $product->id, 'quantity' => 2]]];

    $response = $this
        ->postJson(ORDER_ENDPOINT, $payload)
        ->assertBadRequest()
        ->json();

    $this->assertArrayHasKey('error', $response);
    $this->assertArrayHasKey('products.0.price', $response['error']);

    $errorMessage = $response['error']['products.0.price'][0];

    $this->assertEquals($errorMessage, OrderProductPayloadMessage::ORDER_PRODUCT_PRICE_KEY_IS_REQUIRED);
});

it('should return product price value must be a number message when product price is not a number', function (): void {

    $product = Product::factory()->createOne();

    $payload = ['products' => [['product_id' => $product->id, 'quantity' => 2, 'price' => 'ASD']]];

    $response = $this
        ->postJson(ORDER_ENDPOINT, $payload)
        ->assertBadRequest()
        ->json();

    $this->assertArrayHasKey('error', $response);
    $this->assertArrayHasKey('products.0.price', $response['error']);

    $errorMessage = $response['error']['products.0.price'][0];

    $this->assertEquals($errorMessage, OrderProductPayloadMessage::ORDER_PRODUCT_PRICE_MUST_BE_GREATER_THAN_ZERO);
});

it('should return product quantity key is required message when product quantity does not exists inside order request', function (): void {

    $product = Product::factory()->createOne();

    $payload = ['products' => [['product_id' => $product->id, 'price' => 3.15]]];

    $response = $this
        ->postJson(ORDER_ENDPOINT, $payload)
        ->assertBadRequest()
        ->json();

    $this->assertArrayHasKey('error', $response);
    $this->assertArrayHasKey('products.0.quantity', $response['error']);

    $errorMessage = $response['error']['products.0.quantity'][0];

    $this->assertEquals($errorMessage, OrderProductPayloadMessage::ORDER_PRODUCT_QUANTITY_KEY_IS_REQUIRED);
});

it('should return product quantity value must be greater than zero message when product quantity is not greater than zero', function (): void {

    $product = Product::factory()->createOne();

    $payload = ['products' => [['product_id' => $product->id, 'price' => 3.15, 'quantity' => -1]]];

    $response = $this
        ->postJson(ORDER_ENDPOINT, $payload)
        ->assertBadRequest()
        ->json();

    $this->assertArrayHasKey('error', $response);
    $this->assertArrayHasKey('products.0.quantity', $response['error']);

    $errorMessage = $response['error']['products.0.quantity'][0];

    $this->assertEquals($errorMessage, OrderProductPayloadMessage::ORDER_PRODUCT_QUANTITY_MUST_BE_GREATER_THAN_ZERO);
});

it('should return product quantity value must be a number message when product quantity is not a number', function (): void {

    $product = Product::factory()->createOne();

    $payload = ['products' => [['product_id' => $product->id, 'price' => 3.15, 'quantity' => '3.16']]];

    $response = $this
        ->postJson(ORDER_ENDPOINT, $payload)
        ->assertBadRequest()
        ->json();

    $this->assertArrayHasKey('error', $response);
    $this->assertArrayHasKey('products.0.quantity', $response['error']);

    $errorMessage = $response['error']['products.0.quantity'][0];

    $this->assertEquals($errorMessage, OrderProductPayloadMessage::ORDER_PRODUCT_QUANTITY_MUST_BE_A_NUMBER);
});

it('should return created order when all data inside order requests is valid', function (): void {

    $category = Category::factory()->createOne();

    $products = Product::factory(3)->create(['category_id' => $category]);

    $payload = [
        'products' => [
            [
                'product_id' => $products[0]->id,
                'quantity' => 2,
                'price' => 3.50,
            ],
            [
                'product_id' => $products[1]->id,
                'quantity' => 3,
                'price' => 3.50,
            ],
            [
                'product_id' => $products[2]->id,
                'quantity' => 4,
                'price' => 1.2,
            ],
        ],
    ];

    $response = $this
        ->postJson(ORDER_ENDPOINT, $payload)
        ->assertCreated()
        ->json();

    expect($response)
        ->toHaveKeys([
            'data',
            'data.id',
            'data.total',
            'data.status',
            'data.products',
            'data.products.0.id',
            'data.products.0.name',
            'data.products.0.price',
            'data.products.0.quantity',
            'data.products.1.id',
            'data.products.1.name',
            'data.products.1.price',
            'data.products.1.quantity',
            'data.products.2.id',
            'data.products.2.name',
            'data.products.2.price',
            'data.products.2.quantity',
        ]);
});
