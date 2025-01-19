<?php

namespace App\Reserbadass\Shared\Domain\Criteria;

final class Criteria
{
    private function __construct(
        private Filters $filters,
        private ?Orders $orders = null,
        private ?int $offset = null,
        private ?int $limit = null
    ) {
        $this->orders = $orders ?? Orders::fromValues([]);
    }

    public static function create(
        Filters $filters,
        ?Orders $orders = null,
        ?int $offset = null,
        ?int $limit = null
    ): self {
        return new static(
            $filters,
            $orders,
            $offset,
            $limit
        );
    }

    public function hasFilters(): bool
    {
        return $this->filters->count() > 0;
    }

    public function plainFilters(): array
    {
        return $this->filters->plainFilters();
    }

    public function filters(): Filters
    {
        return $this->filters;
    }

    public function hasOrders(): bool
    {
        return $this->orders->count() > 0;
    }

    public function plainOrders(): array
    {
        return $this->orders->plainOrders();
    }

    public function stringOrders(): array
    {
        return $this->orders->toStrings();
    }

    public function orders(): ?Orders
    {
        return $this->orders;
    }

    public function offset(): ?int
    {
        return $this->offset;
    }

    public function limit(): ?int
    {
        return $this->limit;
    }
}
