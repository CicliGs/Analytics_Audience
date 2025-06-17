<?php

declare(strict_types=1);

namespace App\Filter;

use App\Filter\Collection\CityFilter;
use App\Filter\Collection\CountryFilter;
use App\Filter\Collection\FamilyStatusFilter;
use App\Filter\Collection\GenderFilter;
use App\Filter\Collection\HasChildrenFilter;
use App\Filter\Collection\IsActiveFilter;

readonly class FilterRegistry implements FilterRegistryInterface
{
    public function __construct(
        private FilterPoolInterface $filterPool
    ) {
    }

    public function register(): void
    {
        $this->filterPool->addFilter(new CountryFilter());
        $this->filterPool->addFilter(new CityFilter());
        $this->filterPool->addFilter(new IsActiveFilter());
        $this->filterPool->addFilter(new GenderFilter());
        $this->filterPool->addFilter(new HasChildrenFilter());
        $this->filterPool->addFilter(new FamilyStatusFilter());
    }
}
