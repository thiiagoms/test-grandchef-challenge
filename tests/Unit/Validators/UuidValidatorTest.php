<?php

declare(strict_types=1);

use App\Exceptions\InvalidParameterException;
use App\Messages\System\SystemMessage;
use App\Validators\uuidValidator;
use Pest\Expectation;

it('should throw invalid parameter exception with invalid parameter message when id provided is not a valid uuid',
    fn (): Expectation => expect(fn () => (new uuidValidator)->checkUuidIsValid(fake()->name()))
        ->toThrow(InvalidParameterException::class, SystemMessage::INVALID_PARAMETER)
);
