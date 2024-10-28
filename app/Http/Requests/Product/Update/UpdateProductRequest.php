<?php

namespace App\Http\Requests\Product\Update;

use App\Http\Requests\Product\BaseProductRequest;

class UpdateProductRequest extends BaseProductRequest
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
            'category_id' => [
                'required',
                'uuid',
                'exists:categories,id',
            ],
            'name' => [
                'sometimes',
                'string',
            ],
            'price' => [
                'sometimes',
                'numeric',
                'gt:0',
            ],
        ];
    }

    private function put(): array
    {
        return [
            'category_id' => [
                'required',
                'uuid',
                'exists:categories,id',
            ],
            'name' => [
                'required',
                'string',
            ],
            'price' => [
                'required',
                'numeric',
                'gt:0',
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
