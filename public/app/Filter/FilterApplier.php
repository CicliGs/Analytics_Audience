<?php

declare(strict_types=1);

namespace App\Filter;

readonly class FilterApplier implements FilterApplierInterface
{
    public function __construct(
        private FilterStorageInterface $storage
    ) {
    }

    public function applyFilters(string $query): string
    {
        foreach ($this->storage->getAllFilters() as $filter) {
            $query = $filter->apply($query);
        }

        return $query;
    }
}
