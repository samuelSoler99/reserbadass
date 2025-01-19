<?php

namespace App\Reserbadass\Shared\Domain\Criteria;

final class Filter
{
    private function __construct(private string $field,private mixed $value)
    {
    }

    public static function fromValues(string $field,mixed $value): self
    {
        return new self($field, $value);
    }


    public function field(): string
    {
        return $this->field;
    }

    public function value(): mixed
    {
        return $this->value;
    }
}
