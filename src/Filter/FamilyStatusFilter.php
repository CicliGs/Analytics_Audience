<?php

namespace Src\Filter;

class FamilyStatusFilter implements FilterInterface
{
    public function getFilterName(): string
    {
        return 'familyStatus';
    }

    public function apply(array $filters, string $sql, array &$params): string
    {
        if (isset($filters['familyStatus']) && $filters['familyStatus'] !== '') {
            $params[] = $filters['familyStatus'];
            return 'familyStatus = ?';
        }
        return '';
    }
}
