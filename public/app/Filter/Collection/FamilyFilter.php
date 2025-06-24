<?php

declare(strict_types=1);

namespace App\Filter\Collection;

use App\Filter\AbstractFilter;

class FamilyFilter extends AbstractFilter
{
    public function getName(): string
    {
        return 'familyStatus';
    }

    public function getField(): string
    {
        return 'familyStatus';
    }

    public function getOperator(): string
    {
        return 'ILIKE';
    }

    public function setValue(mixed $value): void
    {
        if ($value === '' || $value === null || $value === 'all') {
            $this->value = null;

            return;
        }

        $this->value = '%' . $value . '%';
    }
}
