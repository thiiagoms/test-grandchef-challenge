<?php

declare(strict_types=1);

namespace App\Validators;

use App\Contracts\Validators\UuidValidatorContract;
use App\Exceptions\InvalidParameterException;
use App\Messages\System\SystemMessage;

class UuidValidator implements UuidValidatorContract
{
    public function checkUuidIsValid(string $id): void
    {
        if (! uuid_is_valid($id)) {
            throw new InvalidParameterException(SystemMessage::INVALID_PARAMETER);
        }
    }
}
