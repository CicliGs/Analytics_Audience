<?php

declare(strict_types=1);

namespace App\Filter;

abstract class AbstractFilter implements FilterInterface
{
    protected mixed $value = null;
    protected string $operator = '=';

    abstract public function getName(): string;

    abstract public function getField(): string;

    public function getOperator(): string
    {
        return $this->operator;
    }

    public function getValue(): mixed
    {
        return $this->value;
    }

    public function setValue(mixed $value): void
    {
        if ($value === '' || $value === null || $value === 'all') {
            $this->value = null;
            return;
        }

        $this->value = $value;
    }

    public function apply(string $query): string
    {
        if ($this->value === null || $this->value === '') {
            return $query;
        }

        $field = $this->getField();
        $operator = $this->getOperator();
        $value = $this->formatValue($this->value);

        if (! str_contains($query, 'WHERE')) {
            $newQuery = sprintf('%s WHERE %s %s %s', $query, $field, $operator, $value);
        } else {
            $newQuery = sprintf('%s AND %s %s %s', $query, $field, $operator, $value);
        }

        return $newQuery;
    }

    protected function formatValue(mixed $value): string
    {
        $isBooleanField = in_array($this->getField(), ['isactive', 'haschildren']);

        if ($isBooleanField) {
            if (is_bool($value)) {
                return $value ? 'TRUE' : 'FALSE';
            }

            if (is_string($value)) {
                $value = strtolower($value);
                if (in_array($value, ['true', '1', 'yes', 't'], true)) {
                    return 'TRUE';
                }
                if (in_array($value, ['false', '0', 'no', 'f'], true)) {
                    return 'FALSE';
                }
            }

            return sprintf("'%s'", $value);
        }

        if (is_string($value)) {
            return sprintf("'%s'", $value);
        }

        return (string)$value;
    }
}
