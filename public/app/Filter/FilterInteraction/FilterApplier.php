<?php

declare(strict_types=1);

namespace App\Filter\FilterInteraction;

class FilterApplier implements FilterApplierInterface
{
    private FilterStorageInterface $storage;

    public function __construct(FilterStorageInterface $storage)
    {
        $this->storage = $storage;
    }

    public function applyFilters(string $query): string
    {
        foreach ($this->storage->getAllFilters() as $filter) {
            $query = $filter->apply($query);
        }

        return $query;
    }
}
