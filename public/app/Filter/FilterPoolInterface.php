<?php

declare(strict_types=1);

namespace App\Filter;

interface FilterPoolInterface
{
    public function addFilter(FilterInterface $filter): void;

    public function getFilter(string $name): ?FilterInterface;

    public function applyFilters(string $query): string;
}
