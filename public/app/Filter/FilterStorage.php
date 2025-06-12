<?php

declare(strict_types=1);

namespace App\Filter;

class FilterStorage implements FilterStorageInterface
{
    /**
     * @var array<string, FilterInterface>
     */
    private array $filters = [];

    public function addFilter(FilterInterface $filter): void
    {
        $this->filters[$filter->getName()] = $filter;
    }

    public function getFilter(string $name): ?FilterInterface
    {
        return $this->filters[$name] ?? null;
    }

    /**
     * @return array<string, FilterInterface>
     */
    public function getAllFilters(): array
    {
        return $this->filters;
    }
}
