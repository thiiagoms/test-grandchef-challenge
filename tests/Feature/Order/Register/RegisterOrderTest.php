<?php

use App\Messages\Order\OrderProductPayloadMessage;
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

// it('should create new order', function (): void {

//     $products = Product::factory(3)->create();

//     $data = [
//         'products' => [
//             [
//                 'product_id' => $products[0]->id,
//                 'quantity' => 2,
//                 'price' => 3.50,
//             ],
//             [
//                 'product_id' => $products[1]->id,
//                 'quantity' => 3,
//                 'price' => 3.50,
//             ],
//             [
//                 'product_id' => $products[2]->id,
//                 'quantity' => 4,
//                 'price' => 3.50,
//             ],
//         ],
//     ];

//     $this
//         ->postJson('/api/orders', $data)
//         ->assertJson(fn (AssertableJson $json): AssertableJson => dd($json));
// });
