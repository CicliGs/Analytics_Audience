<?php

namespace Src;

class FilterService
{
    private static array $filterKeys = [
        'country', 'city', 'isActive', 'gender', 'birthDateStart', 'birthDateEnd',
        'salaryMin', 'salaryMax', 'hasChildren', 'familyStatus',
        'registrationDateStart', 'registrationDateEnd'
    ];

    public static function getFilters(): array
    {
        $filters = [];
        foreach (self::$filterKeys as $key) {
            $filters[$key] = $_POST[$key] ?? '';
        }
        return $filters;
    }
}
