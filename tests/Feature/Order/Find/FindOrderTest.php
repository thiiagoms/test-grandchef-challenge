<?php

use App\Messages\System\SystemMessage;
use Illuminate\Testing\Fluent\AssertableJson;
use Illuminate\Testing\TestResponse;

it(
    'should return resource not found message when order id is not a valid uuid',
    fn (): TestResponse => $this
        ->getJson(ORDER_ENDPOINT.DIRECTORY_SEPARATOR.'invalid-uuid')
        ->assertNotFound()
        ->assertJson(
            fn (AssertableJson $json): AssertableJson => $json
                ->has('message')
                ->whereType('message', 'string')
                ->where('message', SystemMessage::RESOURCE_NOT_FOUND),
        )
);

it(
    'should return resource not found when order id is valid uuid but does not exists in database',
    fn (): TestResponse => $this
        ->getJson(ORDER_ENDPOINT.DIRECTORY_SEPARATOR.fake()->uuid())
        ->assertNotFound()
        ->assertJson(
            fn (AssertableJson $json): AssertableJson => $json
                ->has('message')
                ->whereType('message', 'string')
                ->where('message', SystemMessage::RESOURCE_NOT_FOUND),
        )
);
