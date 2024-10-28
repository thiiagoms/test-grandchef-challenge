<?php

declare(strict_types=1);

namespace App\Messages\Product;

abstract class ProductCategoryMessage
{
    public const string PRODUCT_CATEGORY_ID_IS_REQUIRED = "The product 'category_id' field is required";

    public const string PRODUCT_CATEGORY_ID_MUST_BE_A_VALID_ID = "The product 'category_id' field must be a valid id";

    public const string PRODUCT_CATEGORY_ID_DOES_NOT_EXIST = "The product 'category_id' field does not exist";
}
