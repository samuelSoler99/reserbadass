<?php

namespace App\Reserbadass\Shared\Domain\ValueObject;

use DateTime;
use DateTimeZone;

readonly class DateTimeValueObject
{
    public const WEB_FORMAT = 'd-m-Y H:i';
    public const DATEWEB_FORMAT = 'd-m-Y';

    private const DEFAULT_FORMAT = 'Y-m-d H:i:s';
    private const DEFAULT_TIMEZONE = 'Europe/Madrid';

    protected function __construct(public DateTime $value)
    {
    }

    public static function now(): self
    {
        return new static(new DateTime());
    }

    public static function fromString(?string $date, ?string $format = null, string $timezone = self::DEFAULT_TIMEZONE): ?self
    {
        if(empty($date)) {
            return null;
        }

        if (is_null($format)) {
            $dateTime = new DateTime($date, new DateTimeZone($timezone));
        } else {
            $dateTime = DateTime::createFromFormat($format, $date, new DateTimeZone($timezone));
        }

        return new static($dateTime);
    }

    public function format(string $format = self::DEFAULT_FORMAT): string
    {
        return $this->value->format($format);
    }

    public function formatISO8601(): string
    {
        return $this->format(DateTime::ATOM);
    }

    public function equals(DateTimeValueObject $other): bool
    {
        return $this->value == $other->value;
    }

    public function modify(string $modify): self
    {
        $this->value->modify($modify);
        return $this;
    }
}