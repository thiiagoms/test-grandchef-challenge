<?php

namespace App\Http\Requests\Product\Register;

use App\Http\Requests\Product\BaseProductRequest;

class RegisterProductRequest extends BaseProductRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
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
}
