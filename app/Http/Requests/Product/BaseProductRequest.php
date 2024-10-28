<?php

namespace App\Http\Requests\Product;

use App\Messages\Product\ProductCategoryMessage;
use App\Messages\Product\ProductNameMessage;
use App\Messages\Product\ProductPriceMessage;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;

class BaseProductRequest extends FormRequest
{
    public function failedValidation(Validator $validator): void
    {
        throw new HttpResponseException(
            (response()->json(['error' => $validator->errors()], Response::HTTP_BAD_REQUEST))
        );
    }

    private function getProductCategoryIdMessage(): array
    {
        return [
            'category_id.required' => ProductCategoryMessage::PRODUCT_CATEGORY_ID_IS_REQUIRED,
            'category_id.uuid' => ProductCategoryMessage::PRODUCT_CATEGORY_ID_MUST_BE_A_VALID_ID,
            'category_id.exists' => ProductCategoryMessage::PRODUCT_CATEGORY_ID_DOES_NOT_EXIST,
        ];
    }

    private function getProductNameMessage(): array
    {
        return [
            'name.required' => ProductNameMessage::PRODUCT_NAME_IS_REQUIRED,
            'name.string' => ProductNameMessage::PRODUCT_NAME_MUST_BE_A_STRING,
        ];
    }

    private function getProductPriceMessage(): array
    {
        return [
            'price.required' => ProductPriceMessage::PRODUCT_PRICE_IS_REQUIRED,
            'price.gt' => ProductPriceMessage::PRODUCT_PRICE_MUST_BE_GREATER_THAN_ZERO,
            'price.numeric' => ProductPriceMessage::PRODUCT_PRICE_MUST_BE_A_NUMBER,
        ];
    }

    public function messages(): array
    {
        return array_merge(
            $this->getProductCategoryIdMessage(),
            $this->getProductNameMessage(),
            $this->getProductPriceMessage()
        );
    }
}
