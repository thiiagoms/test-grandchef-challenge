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
                'uuid',
                'exists:products,id',
            ],
            'products.*.quantity' => [
                'required',
                'integer',
                'gt:0',
            ],
            'products.*.price' => [
                'required',
                'numeric',
                'gt:0',
            ],
        ];
    }
}
