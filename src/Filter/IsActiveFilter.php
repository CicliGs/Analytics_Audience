<?php

namespace Src\Filter;

class IsActiveFilter implements FilterInterface
{
    public function getFilterName(): string
    {
        return 'isActive';
    }

    public function apply(array $filters, string $sql, array &$params): string
    {
        if (isset($filters['isActive']) && $filters['isActive'] !== '') {
            $params[] = $filters['isActive'] === 'true' ? 1 : 0;
            return 'is_active = ?';
        }
        return '';
    }
}