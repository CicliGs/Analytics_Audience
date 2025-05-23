<?php

declare(strict_types=1);

namespace App\Filter\Collection;

use App\Filter\AbstractFilter;

class FamilyStatusFilter extends AbstractFilter
{
    public function getName(): string
    {
        return 'familyStatus';
    }

    public function getField(): string
    {
        return 'familystatus';
    }
}
