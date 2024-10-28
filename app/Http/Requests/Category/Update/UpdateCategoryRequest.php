<?php

namespace App\Http\Requests\Category\Update;

use App\Http\Requests\Category\BaseCategoryRequest;

class UpdateCategoryRequest extends BaseCategoryRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    private function patch(): array
    {
        return [
            'name' => [
                'sometimes',
                'string',
            ],
            'description' => [
                'sometimes',
                'string',
            ],
        ];
    }

    private function put(): array
    {
        return [
            'name' => [
                'required',
                'string',
            ],
            'description' => [
                'required',
                'string',
            ],
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return match ($this->method()) {
            'PATCH' => $this->patch(),
            default => $this->put()
        };
    }
}
