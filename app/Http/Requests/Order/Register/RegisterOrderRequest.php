<?php

namespace App\Http\Requests\Order\Register;

use App\Http\Requests\Order\BaseOrderRequest;

class RegisterOrderRequest extends BaseOrderRequest
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
            'products' => [
                'required',
                'array',
                'min:1',
            ],
            'products.*.product_id' => [
                'required',
                'exists:products,id',
            ],
            'products.*.price' => [
                'required',
                'gt:0',
                'numeric',
            ],
            'products.*.quantity' => [
                'required',
                'integer',
                'gt:0',
            ],
        ];
    }
}
