<?php

declare(strict_types=1);

namespace App\Messages\System;

abstract class SystemMessage
{
    public const string RESOURCE_NOT_FOUND = 'Resource not found';

    public const string INVALID_PARAMETER = 'Invalid parameter was given';

    public const string GENERIC_ERROR = 'Something went wrong, please try again later';
}
