<?php

namespace App\Reserbadass\Shared\Domain\ValueObject;


use App\Reserbadass\Shared\Domain\Exception\InvalidIntValue;

class IntegerValueObject
{
    protected function __construct(public int $value)
    {
    }

    public static function fromInt(?int $value): ?self
    {
        if ($value === null) {
            return null;
        }

        return new static($value);
    }

    /**
     * @throws InvalidIntValue
     */
    public static function fromString(?string $idString): ?self
    {
        if ($idString === null) {
            return null;
        }

        if (!ctype_digit($idString)) {
            throw new InvalidIntValue();
        }

        $id = (int)$idString;
        return new static($id);
    }

    public function equals(IntegerValueObject $other): bool
    {
        return $this->value === $other->value;
    }
}