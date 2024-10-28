<?php

declare(strict_types=1);

namespace App\Messages\Product;

abstract class ProductNameMessage
{
    public const string PRODUCT_NAME_IS_REQUIRED = "The product 'name' field is required";

    public const string PRODUCT_NAME_MUST_BE_A_STRING = "The product 'name' field must be a string";
}
