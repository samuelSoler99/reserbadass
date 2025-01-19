<?php

namespace App\Reserbadass\Shared\Domain\Criteria;

use App\Reserbadass\Shared\Domain\Utils\Collection;

final class Orders extends Collection
{
    protected function type(): string
    {
        return Order::class;
    }

    public static function fromValues(array $values): self
    {
        $items = [];

        foreach ($values as $field => $value) {
            $items[] = Order::fromValues($field, $value);
        }

        return new self($items);
    }

    public static function fromStrings(array $orders): self
    {
        $items = [];

        foreach ($orders as $order) {
            $items[] = Order::fromString($order);
        }

        return new self($items);
    }

    public function add(Order $order): self
    {
        return new self(array_merge($this->items(), [$order]));
    }

    public function getOrders(): array
    {
        return $this->items();
    }

    public function plainOrders(): array
    {
        $items = [];
        foreach ($this->items() as $item) {
            $items[$item->field()] = $item->type();
        }
        return $items;
    }

    /**
     * @return string[]
     */
    public function toStrings(): array
    {
        $items = [];
        /** @var Order $item */
        foreach ($this->items() as $item) {
            $items[] = (string) $item;
        }
        return $items;
    }
}
