<?php

declare(strict_types=1);

namespace App\Filter;

readonly class FilterPool implements FilterPoolInterface
{
    public function __construct(
        private FilterStorageInterface $storage,
        private FilterApplierInterface $applier
    ) {
    }

    public function addFilter(FilterInterface $filter): void
    {
        $this->storage->addFilter($filter);
    }

    public function getFilter(string $name): ?FilterInterface
    {
        return $this->storage->getFilter($name);
    }

    public function applyFilters(string $query): string
    {
        return $this->applier->applyFilters($query);
    }
}
