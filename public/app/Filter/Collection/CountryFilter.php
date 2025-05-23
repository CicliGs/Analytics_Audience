<?php

declare(strict_types=1);

namespace App\Filter\Collection;

use App\Filter\AbstractFilter;

class CountryFilter extends AbstractFilter
{
    public function getName(): string
    {
        return 'country';
    }

    public function getField(): string
    {
        return 'country';
    }
}
