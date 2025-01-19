<?php

namespace App\Reserbadass\Shared\Domain\Criteria;

final class Order
{
    public const ASC = 'ASC';

    public const DESC = 'DESC';

    private function __construct(
        private string $field,
        private string $type
    ) {
    }

    public static function fromValues(string $field, string $type): self
    {
        return new self($field, $type);
    }

    public static function fromString(string $order): self
    {
        if (strpos($order, '-') !== false) {
            return new self(str_replace('-', '', $order), self::DESC);
        }

        return new self(str_replace('+', '', $order), self::ASC);
    }

    public static function createAsc(string $field): self
    {
        return new self($field, self::ASC);
    }

    public static function createDesc(string $field): self
    {
        return new self($field, self::DESC);
    }

    public function field(): string
    {
        return $this->field;
    }

    public function type(): string
    {
        return $this->type;
    }

    public function __toString(): string
    {
        if ($this->type == self::DESC) {
            return '-' . $this->field;
        }

        return $this->field;
    }
}
