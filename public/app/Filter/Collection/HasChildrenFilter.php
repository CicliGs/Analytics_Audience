<?php

declare(strict_types=1);

namespace App\Filter\Collection;

use App\Filter\AbstractFilter;

class HasChildrenFilter extends AbstractFilter
{
    public function getName(): string
    {
        return 'hasChildren';
    }

    public function getField(): string
    {
        return 'has_children';
    }

    public function setValue(mixed $value): void
    {
        if ($value === '' || $value === null || $value === 'all') {
            $this->value = null;

            return;
        }

        if (is_string($value)) {
            $value = strtolower($value);
            if (in_array($value, ['true', '1', 'yes', 't'], true)) {
                $this->value = 't';

                return;
            }
            if (in_array($value, ['false', '0', 'no', 'f'], true)) {
                $this->value = 'f';

                return;
            }
        }

        $this->value = $value;
    }
}
