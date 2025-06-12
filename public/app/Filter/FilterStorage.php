<?php

declare(strict_types=1);

namespace App\Filter;

class FilterStorage implements FilterStorageInterface
{
    private array $filters = [];

    public function addFilter(FilterInterface $filter): void
    {
        $this->filters[$filter->getName()] = $filter;
    }

    public function getFilter(string $name): ?FilterInterface
    {
        return $this->filters[$name] ?? null;
    }

    public function getAllFilters(): array
    {
        return $this->filters;
    }
}
