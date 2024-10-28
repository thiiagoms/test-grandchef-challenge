<?php

namespace App\Http\Requests\Category;

use App\Messages\Category\CategoryDescriptionMessage;
use App\Messages\Category\CategoryNameMessage;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;

abstract class BaseCategoryRequest extends FormRequest
{
    /**
     * @throws HttpResponseException
     */
    public function failedValidation(Validator $validator): void
    {
        throw new HttpResponseException(
            (response()->json(['error' => $validator->errors()], Response::HTTP_BAD_REQUEST))
        );
    }

    public function getCategoryNameMessages(): array
    {
        return [
            'name.required' => CategoryNameMessage::CATEGORY_NAME_IS_REQUIRED,
            'name.string' => CategoryNameMessage::CATEGORY_NAME_MUST_BE_A_STRING,
        ];
    }

    public function getCategoryDescriptionMessages(): array
    {
        return [
            'description.required' => CategoryDescriptionMessage::CATEGORY_DESCRIPTION_IS_REQUIRED,
            'description.string' => CategoryDescriptionMessage::CATEGORY_DESCRIPTION_MUST_BE_A_STRING,
        ];
    }

    public function messages(): array
    {
        return array_merge($this->getCategoryNameMessages(), $this->getCategoryDescriptionMessages());
    }
}
