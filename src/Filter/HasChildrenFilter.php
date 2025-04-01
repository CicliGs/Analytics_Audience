<?php

namespace Src\Filter;

class HasChildrenFilter implements FilterInterface
{
    public function getFilterName(): string
    {
        return 'hasChildren';
    }

    public function apply(array $filters, string $sql, array &$params): string
    {
        if (isset($filters['hasChildren']) && $filters['hasChildren'] !== '') {
            $params[] = $filters['hasChildren'] === 'true' ? 1 : 0;
            return 'hasChildren = ?';
        }
        return '';
    }
}
