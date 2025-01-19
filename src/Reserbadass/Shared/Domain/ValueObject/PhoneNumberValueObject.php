<?php

namespace App\Reserbadass\Shared\Domain\ValueObject;

use App\Reserbadass\Shared\Domain\Exception\InvalidPhoneNumber;

final readonly class PhoneNumberValueObject extends StringValueObject
{
    private function __construct(string $phoneNumber,
    ) {
        $this->checkValidPhoneNumber($phoneNumber);
        parent::__construct($phoneNumber);
    }

    private function checkValidPhoneNumber(string $phoneNumber): void
    {
        if (empty($phoneNumber)) {
            return;
        }

        if (strlen($phoneNumber) != 9 || !ctype_digit($phoneNumber)) {
            throw new InvalidPhoneNumber();
        }
    }
}