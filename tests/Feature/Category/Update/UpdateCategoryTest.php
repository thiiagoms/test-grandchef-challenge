<?php

use App\Messages\Category\CategoryDescriptionMessage;
use App\Messages\Category\CategoryNameMessage;
use App\Messages\System\SystemMessage;
use App\Models\Category;
use Illuminate\Testing\Fluent\AssertableJson;
use Illuminate\Testing\TestResponse;

beforeEach(fn (): Category => $this->category = Category::factory()->create());

it('should return resource not found when category id is not a valid uuid',
    fn (): TestResponse => $this
        ->patchJson(CATEGORY_ENDPOINT.DIRECTORY_SEPARATOR.'invalid-uuid')
        ->assertNotFound()
        ->assertJson(
            fn (AssertableJson $json): AssertableJson => $json
                ->has('message')
                ->whereType('message', 'string')
                ->where('message', SystemMessage::RESOURCE_NOT_FOUND),
        )
);

it('should return resource not found when category id is valid uuid but does not exists in database',
    fn (): TestResponse => $this
        ->patchJson(CATEGORY_ENDPOINT.DIRECTORY_SEPARATOR.fake()->uuid())
        ->assertNotFound()
        ->assertJson(
            fn (AssertableJson $json): AssertableJson => $json
                ->has('message')
                ->whereType('message', 'string')
                ->where('message', SystemMessage::RESOURCE_NOT_FOUND),
        )
);

it('should return category name field must be a string when category name field is not a string',
    fn (): TestResponse => $this
        ->patchJson(CATEGORY_ENDPOINT.DIRECTORY_SEPARATOR.$this->category->id, ['name' => 123])
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

it('should return category description field must be a string when category description field is not a string',
    fn (): TestResponse => $this
        ->patchJson(CATEGORY_ENDPOINT.DIRECTORY_SEPARATOR.$this->category->id, ['description' => 123])
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

it('should return all fields are required when category fields are empty but it is a put request',
    fn (): TestResponse => $this
        ->putJson(CATEGORY_ENDPOINT.DIRECTORY_SEPARATOR.$this->category->id)
        ->assertBadRequest()
        ->assertJson(
            fn (AssertableJson $json): AssertableJson => $json
                ->hasAll([
                    'error',
                    'error.name',
                    'error.name.0',
                    'error.description',
                    'error.description.0',
                ])
                ->whereAllType([
                    'error' => 'array',
                    'error.name' => 'array',
                    'error.name.0' => 'string',
                    'error.description' => 'array',
                    'error.description.0' => 'string',
                ])
                ->whereAll([
                    'error.name.0' => CategoryNameMessage::CATEGORY_NAME_IS_REQUIRED,
                    'error.description.0' => CategoryDescriptionMessage::CATEGORY_DESCRIPTION_IS_REQUIRED,
                ])
        )
);

it('should return all fields must be a valid string when category fields are not a string',
    fn (): TestResponse => $this
        ->putJson(CATEGORY_ENDPOINT.DIRECTORY_SEPARATOR.$this->category->id, [
            'name' => 123,
            'description' => 123,
        ])
        ->assertBadRequest()
        ->assertJson(
            fn (AssertableJson $json): AssertableJson => $json
                ->hasAll([
                    'error',
                    'error.name',
                    'error.name.0',
                    'error.description',
                    'error.description.0',
                ])
                ->whereAllType([
                    'error' => 'array',
                    'error.name' => 'array',
                    'error.name.0' => 'string',
                    'error.description' => 'array',
                    'error.description.0' => 'string',
                ])
                ->whereAll([
                    'error.name.0' => CategoryNameMessage::CATEGORY_NAME_MUST_BE_A_STRING,
                    'error.description.0' => CategoryDescriptionMessage::CATEGORY_DESCRIPTION_MUST_BE_A_STRING,
                ])
        )
);

it('should update only category name when only category name field is provided and return updated category data',
    fn (): TestResponse => $this
        ->patchJson(CATEGORY_ENDPOINT.DIRECTORY_SEPARATOR.$this->category->id, ['name' => 'Category2'])
        ->assertOk()
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
                    'data.id' => $this->category->id,
                    'data.name' => 'Category2',
                    'data.description' => $this->category->description,
                ])
        )
);

it('should update only category description when only category description field is provided and return updated category data',
    fn (): TestResponse => $this
        ->patchJson(CATEGORY_ENDPOINT.DIRECTORY_SEPARATOR.$this->category->id, ['description' => 'description 2'])
        ->assertOk()
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
                    'data.id' => $this->category->id,
                    'data.name' => $this->category->name,
                    'data.description' => 'description 2',
                ])
        )
);

it('should update entire category when all fields are provided and return updated category data',
    fn (): TestResponse => $this
        ->patchJson(CATEGORY_ENDPOINT.DIRECTORY_SEPARATOR.$this->category->id, [
            'name' => 'Category2',
            'description' => 'description 2',
        ])
        ->assertOk()
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
                    'data.id' => $this->category->id,
                    'data.name' => 'Category2',
                    'data.description' => 'description 2',
                ])
        )
);
