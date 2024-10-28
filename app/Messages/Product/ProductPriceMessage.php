<?php

declare(strict_types=1);

namespace App\Messages\Product;

abstract class ProductPriceMessage
{
    public const string PRODUCT_PRICE_IS_REQUIRED = "The product 'price' field is required.";

    public const string PRODUCT_PRICE_MUST_BE_A_NUMBER = "The product 'price' field must be numeric";

    public const string PRODUCT_PRICE_MUST_BE_GREATER_THAN_ZERO = "The product 'price' field must be greater than zero";
}
