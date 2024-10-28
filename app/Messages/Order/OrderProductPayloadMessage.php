<?php

declare(strict_types=1);

namespace App\Messages\Order;

abstract class OrderProductPayloadMessage
{
    public const string ORDER_PRODUCT_KEY_IS_REQUIRED = "The order 'products' key is required.";

    public const string ORDER_PRODUCT_KEY_MUST_BE_VALID_ARRAY = "The order 'products' must be a valid array.";

    // public const string ORDER_PRODUCT_KEY_MUST_CONTAIN_AT_LEAST_ONE_ITEM = "The order 'products' must contain at least one item.";
}
