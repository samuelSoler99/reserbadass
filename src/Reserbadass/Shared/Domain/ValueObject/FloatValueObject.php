<?php

namespace App\Reserbadass\Shared\Domain\ValueObject;

readonly class FloatValueObject
{
    protected function __construct(public float $value)
    {
    }

    public static function fromFloat(float $value): self
    {
        return new static($value);
    }
}