<?php

namespace Src\Filter;

class CountryFilter implements FilterInterface
{
    public function getFilterName(): string
    {
        return 'country';
    }

    public function apply(array $filters, string $sql, array &$params): string
    {
        $params[] = $filters['country'];
        return 'country = ?';
    }
}