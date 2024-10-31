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

    private function getOrderProductIdMessage(): array
    {
        return [
            'products.*.product_id.required' => OrderProductPayloadMessage::ORDER_PRODUCT_ID_KEY_IS_REQUIRED,
            'products.*.product_id.exists' => OrderProductPayloadMessage::ORDER_PRODUCT_ID_DOEST_NOT_EXISTS_IN_DATABASE,
        ];
    }

    private function getOrderProductPriceMessage(): array
    {
        return [
            'products.*.price.required' => OrderProductPayloadMessage::ORDER_PRODUCT_PRICE_KEY_IS_REQUIRED,
            'products.*.price.gt' => OrderProductPayloadMessage::ORDER_PRODUCT_PRICE_MUST_BE_GREATER_THAN_ZERO,
        ];
    }

    private function getOrderProductQuantityMessage(): array
    {
        return [
            'products.*.quantity.required' => OrderProductPayloadMessage::ORDER_PRODUCT_QUANTITY_KEY_IS_REQUIRED,
            'products.*.quantity.gt' => OrderProductPayloadMessage::ORDER_PRODUCT_QUANTITY_MUST_BE_GREATER_THAN_ZERO,
            'products.*.quantity.integer' => OrderProductPayloadMessage::ORDER_PRODUCT_QUANTITY_MUST_BE_A_NUMBER,
        ];
    }

    public function messages(): array
    {
        return array_merge(
            $this->getOrderProductPayloadMessage(),
            $this->getOrderProductIdMessage(),
            $this->getOrderProductPriceMessage(),
            $this->getOrderProductQuantityMessage(),
        );
    }
}
