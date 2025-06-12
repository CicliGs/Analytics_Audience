<?php

declare(strict_types=1);

namespace App\Filter;

interface FilterStorageInterface
{
    public function addFilter(FilterInterface $filter): void;

    public function getFilter(string $name): ?FilterInterface;

    public function getAllFilters(): array;
}
