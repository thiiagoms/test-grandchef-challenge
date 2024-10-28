<?php

declare(strict_types=1);

namespace App\Messages\Category;

class CategoryDescriptionMessage
{
    public const string CATEGORY_DESCRIPTION_IS_REQUIRED = "The category 'description' field is required.";

    public const string CATEGORY_DESCRIPTION_MUST_BE_A_STRING = "The category 'description' must be a string.";
}
