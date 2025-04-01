<?php

namespace Src\Filter;

class GenderFilter implements FilterInterface
{
    public function getFilterName(): string
    {
        return 'gender';
    }

    public function apply(array $filters, string $sql, array &$params): string
    {
        if (isset($filters['gender']) && $filters['gender'] !== '') {
            $params[] = $filters['gender'];
            return 'gender = ?';
        }
        return '';
    }
}
