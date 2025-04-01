<?php

namespace Src\Filter;

class CityFilter implements FilterInterface
{
    public function getFilterName(): string
    {
        return 'city';
    }

    public function apply(array $filters, string $sql, array &$params): string
    {
        $params[] = $filters['city'];
        return 'city = ?';
    }
}
