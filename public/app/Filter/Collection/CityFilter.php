<?php

declare(strict_types=1);

namespace App\Filter\Collection;

use App\Filter\AbstractFilter;

class CityFilter extends AbstractFilter
{
    public function getName(): string
    {
        return 'city';
    }

    public function getField(): string
    {
        return 'city';
    }
}
