<?php

namespace App\Reserbadass\Shared\Domain\Criteria;

use App\Reserbadass\Shared\Domain\Utils\Collection;

final class Filters extends Collection
{
    protected function type(): string
    {
        return Filter::class;
    }

    public static function fromValues(array $values): self
    {
        $items = [];

        foreach ($values as $field => $value) {
            $items[] = Filter::fromValues($field, $value);
        }

        return new self($items);
    }

    public function add(Filter $filter): self
    {
        return new self(array_merge($this->items(), [$filter]));
    }

    public function getFilters(): array
    {
        return $this->items();
    }

    public function plainFilters(): array
    {
        $items = [];
        foreach ($this->items() as $item) {
            $items[$item->field()] = $item->value();
        }
        return $items;
    }
}
