<?php

namespace Src\Filter;

class FilterPool
{
    private array $filters = [];

    public function addFilter(FilterInterface $filter): void
    {
        $this->filters[] = $filter;
    }

    public function applyFilters(array $filters, string $sql, array &$params): string
    {
        $conditions = [];

        foreach ($this->filters as $filter) {
            if (!empty($filters[$filter->getFilterName()])) {
                $conditions[] = $filter->apply($filters, $sql, $params);
            }
        }

        if (!empty($conditions)) {
            $sql = "SELECT * FROM users WHERE " . implode(" AND ", $conditions);
        }

        return $sql;
    }
}
