<?php

declare(strict_types=1);

namespace App\Filter\Collection;

use App\Filter\AbstractFilter;

class HasChildrenFilter extends AbstractFilter
{
    public function getName(): string
    {
        return 'haschildren';
    }

    public function getField(): string
    {
        return 'haschildren';
    }

    public function setValue(mixed $value): void
    {
        if (is_string($value)) {
            $value = strtolower($value);
            $this->value = in_array($value, ['true', '1', 'yes'], true);
        } else {
            $this->value = (bool)$value;
        }
    }
}
