<?php

declare(strict_types=1);

namespace App\Filter\FilterInteraction;

use App\Filter\FilterInterface;
use App\Filter\FilterInteraction\FilterStorage;
use App\Filter\FilterInteraction\FilterApplier;

class FilterPool implements FilterPoolInterface
{
    private FilterStorageInterface $storage;
    private FilterApplierInterface $applier;

    public function __construct()
    {
        $this->storage = new FilterStorage();
        $this->applier = new FilterApplier($this->storage);
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
