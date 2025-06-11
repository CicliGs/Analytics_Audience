<?php

declare(strict_types=1);

namespace App\Filter;

interface FilterApplierInterface
{
    public function applyFilters(string $query): string;
}
