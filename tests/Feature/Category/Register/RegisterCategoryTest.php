<?php

use App\Messages\Category\CategoryDescriptionMessage;
use App\Messages\Category\CategoryNameMessage;
use Illuminate\Testing\Fluent\AssertableJson;
use Illuminate\Testing\TestResponse;

it('should return category name field is required message when category name field is empty',
    fn (): TestResponse => $this
        ->postJson(CATEGORY_ENDPOINT, ['name' => ''])
        ->assertBadRequest()
        ->assertJson(
            fn (AssertableJson $json): AssertableJson => $json
                ->hasAll([
                    'error',
                    'error.name',
                    'error.name.0',
                ])
                ->whereAllType([
                    'error' => 'array',
                    'error.name' => 'array',
                    'error.name.0' => 'string',
                ])
                ->where('error.name.0', CategoryNameMessage::CATEGORY_NAME_IS_REQUIRED)
        )
);

it('should return category name must be a string message when category name field is not a string',
    fn (): TestResponse => $this
        ->postJson(CATEGORY_ENDPOINT, ['name' => 1])
        ->assertBadRequest()
        ->assertJson(
            fn (AssertableJson $json): AssertableJson => $json
                ->hasAll([
                    'error',
                    'error.name',
                    'error.name.0',
                ])
                ->whereAllType([
                    'error' => 'array',
                    'error.name' => 'array',
                    'error.name.0' => 'string',
                ])
                ->where('error.name.0', CategoryNameMessage::CATEGORY_NAME_MUST_BE_A_STRING)
        )
);

it('should return category description field must be a string message when category description field is not a string',
    fn (): TestResponse => $this
        ->postJson(CATEGORY_ENDPOINT, ['name' => 'Category1', 'description' => 12])
        ->assertBadRequest()
        ->assertJson(
            fn (AssertableJson $json): AssertableJson => $json
                ->hasAll([
                    'error',
                    'error.description',
                    'error.description.0',
                ])
                ->whereAllType([
                    'error' => 'array',
                    'error.description' => 'array',
                    'error.description.0' => 'string',
                ])
                ->where('error.description.0', CategoryDescriptionMessage::CATEGORY_DESCRIPTION_MUST_BE_A_STRING)
        )
);

it('should return created category data when only category name is provided and category is created',
    fn (): TestResponse => $this
        ->postJson(CATEGORY_ENDPOINT, ['name' => 'Category1'])
        ->assertCreated()
        ->assertJson(
            fn (AssertableJson $json): AssertableJson => $json
                ->hasAll([
                    'data',
                    'data.id',
                    'data.name',
                    'data.created_at',
                    'data.updated_at',
                ])
                ->whereAllType([
                    'data' => 'array',
                    'data.id' => 'string',
                    'data.name' => 'string',
                    'data.created_at' => 'string',
                    'data.updated_at' => 'string',
                ])
                ->where('data.name', 'Category1')
        )
);

it('should return created category data when all provided data is valid and category is created',
    fn (): TestResponse => $this
        ->postJson(CATEGORY_ENDPOINT, ['name' => 'Category1', 'description' => 'Category1 description'])
        ->assertCreated()
        ->assertJson(
            fn (AssertableJson $json): AssertableJson => $json
                ->hasAll([
                    'data',
                    'data.id',
                    'data.name',
                    'data.description',
                    'data.created_at',
                    'data.updated_at',
                ])
                ->whereAllType([
                    'data' => 'array',
                    'data.id' => 'string',
                    'data.name' => 'string',
                    'data.description' => 'string',
                    'data.created_at' => 'string',
                    'data.updated_at' => 'string',
                ])
                ->whereAll([
                    'data.name' => 'Category1',
                    'data.description' => 'Category1 description',
                ])
        )
);
