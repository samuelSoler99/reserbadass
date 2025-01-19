<?php

namespace App\Reserbadass\Shared\Domain\ValueObject;

abstract readonly class PasswordValueObject
{
    public const HASH_ALGORITHM = 'sha256';
    private string $plainTextValue;

    protected function __construct(
        public string $value
    ) {
    }

    public function __toString(): string
    {
        return $this->value;
    }

    public static function fromString(?string $string): ?self
    {
        if(empty($string)) {
            return null;
        }

        $obj = new static(hash(static::HASH_ALGORITHM, $string));
        $obj->setPlainTextValue($string);
        return $obj;
    }

    public static function fromHash(?string $hash): ?self
    {
        if(empty($hash)) {
            return null;
        }

        return new static($hash);
    }

    private function setPlainTextValue(string $string): void
    {
        $this->plainTextValue = $string;
    }
}