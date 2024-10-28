<?php

declare(strict_types=1);

namespace App\Messages\Category;

abstract class CategoryNameMessage
{
    public const string CATEGORY_NAME_IS_REQUIRED = "The category 'name' field is required.";

    public const string CATEGORY_NAME_MUST_BE_A_STRING = "The category 'name' field must be a string.";
}
