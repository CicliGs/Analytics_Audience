<?php

declare(strict_types=1);

namespace App\Filter\Collection;

use App\Filter\AbstractFilter;

class GenderFilter extends AbstractFilter
{
    public function getName(): string
    {
        return 'gender';
    }

    public function getField(): string
    {
        return 'gender';
    }
}
