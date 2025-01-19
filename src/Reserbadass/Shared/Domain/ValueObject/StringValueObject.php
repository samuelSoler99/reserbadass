<?php

namespace App\Reserbadass\Shared\Domain\ValueObject;

readonly class StringValueObject
{
    protected function __construct(public string $value)
    {
    }

    public function __toString(): string
    {
        return $this->value;
    }

    public static function fromString(?string $string): ?self
    {
        if (is_null($string)) {
            return null;
        }

        return new static($string);
    }

    public function capitalize(): string
    {
        return ucwords(strtolower($this->value));
    }

    public function equals(self $other): bool
    {
        return $this->value === $other->value;
    }
}