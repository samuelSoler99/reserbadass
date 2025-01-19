<?php

namespace App\Reserbadass\Shared\Domain\Utils;

use ArrayIterator;
use Countable;
use InvalidArgumentException;
use IteratorAggregate;
use Traversable;

abstract class Collection implements Countable, IteratorAggregate
{
    public function __construct(private array $items)
    {
        $this->checkTypes($items);

    }

    abstract protected function type(): string;


    public function getIterator(): ArrayIterator|Traversable
    {
        return new ArrayIterator($this->items());
    }

    public function count(): int
    {
        return count($this->items());
    }

    public function items(): array
    {
        return $this->items;
    }

    public function item(int $index): object
    {
        return $this->items()[$index];
    }

    public function checkTypes(array $items): void
    {
        foreach ($items as $item) {
            $type = $this->type();
            if (!$item instanceof $type) {
                throw new InvalidArgumentException(
                    sprintf('The object <%s> is not an instance of <%s>', $type, get_class($item))
                );
            }
        }
    }

    public function equals(?Collection $otherCollection): bool
    {
        if (!isset($otherCollection)) {
            return false;
        }

        return $this->items() == $otherCollection->items();
    }
}
