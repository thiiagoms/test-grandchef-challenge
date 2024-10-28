<?php

namespace App\Http\Requests\Order;

use App\Messages\Order\OrderProductPayloadMessage;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;

abstract class BaseOrderRequest extends FormRequest
{
    public function failedValidation(Validator $validator): void
    {
        throw new HttpResponseException(
            (response()->json(['error' => $validator->errors()], Response::HTTP_BAD_REQUEST))
        );
    }

    private function getOrderProductPayloadMessage(): array
    {
        return [
            'products.required' => OrderProductPayloadMessage::ORDER_PRODUCT_KEY_IS_REQUIRED,
            'products.array' => OrderProductPayloadMessage::ORDER_PRODUCT_KEY_MUST_BE_VALID_ARRAY,
        ];
    }

    // private function getOrderProductIdMessage(): array
    // {
    //     return [];
    // }

    // private function getOrderProductQuantityMessage(): array
    // {
    //     return [];
    // }

    // private function getOrderProductPriceMessage(): array
    // {
    //     return [];
    // }

    public function messages(): array
    {
        return array_merge(
            $this->getOrderProductPayloadMessage(),
            // $this->getOrderProductIdMessage(),
            // $this->getOrderProductQuantityMessage(),
            // $this->getOrderProductPriceMessage()
        );
    }
}
