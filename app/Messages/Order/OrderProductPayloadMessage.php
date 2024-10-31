<?php

declare(strict_types=1);

namespace App\Messages\Order;

abstract class OrderProductPayloadMessage
{
    /**
     * |-------------------------------------
     * | Product key
     * |-------------------------------------
     */
    public const string ORDER_PRODUCT_KEY_IS_REQUIRED = "The 'products' key inside request is required.";

    public const string ORDER_PRODUCT_KEY_MUST_BE_VALID_ARRAY = "The 'products' key must be a valid array.";

    /**
     * |-------------------------------------
     * | Product Id
     * |-------------------------------------
     */
    public const string ORDER_PRODUCT_ID_KEY_IS_REQUIRED = "The 'product_id' key inside products array is required";

    public const string ORDER_PRODUCT_ID_DOEST_NOT_EXISTS_IN_DATABASE = "The 'product_id' value inside products array does not exists in database";

    /**
     * |-------------------------------------
     * | Product price
     * |-------------------------------------
     */
    public const string ORDER_PRODUCT_PRICE_KEY_IS_REQUIRED = "The 'price' key inside products array is required";

    public const string ORDER_PRODUCT_PRICE_MUST_BE_GREATER_THAN_ZERO = "The 'price' key inside products array must be greater than zero";

    /**
     * |-------------------------------------
     * | Product quantity
     * |-------------------------------------
     */
    public const string ORDER_PRODUCT_QUANTITY_KEY_IS_REQUIRED = "The 'quantity' key inside products array is required";

    public const string ORDER_PRODUCT_QUANTITY_MUST_BE_GREATER_THAN_ZERO = "The 'quantity' key inside products array must be greater than zero";

    public const string ORDER_PRODUCT_QUANTITY_MUST_BE_A_NUMBER = "The 'quantity' key inside products array must be a integer";
}
