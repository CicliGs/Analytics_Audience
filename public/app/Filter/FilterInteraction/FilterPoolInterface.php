<?php

declare(strict_types=1);

namespace App\Filter\FilterInteraction;

use App\Filter\FilterInterface;

interface FilterPoolInterface
{
    public function addFilter(FilterInterface $filter): void;

    public function getFilter(string $name): ?FilterInterface;

    public function applyFilters(string $query): string;
}
