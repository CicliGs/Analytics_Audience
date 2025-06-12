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
            return sprintf('%s WHERE %s %s %s', $query, $field, $operator, $value);
        }

        return sprintf('%s AND %s %s %s', $query, $field, $operator, $value);
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
                if ($value === 'true' || $value === '1') {
                    return 'TRUE';
                }
                if ($value === 'false' || $value === '0') {
                    return 'FALSE';
                }
            }

            return $value ? 'TRUE' : 'FALSE';
        }
        if (is_string($value)) {
            return sprintf("'%s'", $value);
        }

        return (string)$value;
    }
}
