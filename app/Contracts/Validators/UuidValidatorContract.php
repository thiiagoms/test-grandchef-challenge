<?php

declare(strict_types=1);

namespace App\Contracts\Validators;

use App\Exceptions\InvalidParameterException;

interface UuidValidatorContract
{
    /**
     * @throws InvalidParameterException
     */
    public function checkUuidIsValid(string $id): void;
}
