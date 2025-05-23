<?php

declare(strict_types=1);

namespace App\Filter;

interface FilterInterface
{
    public function getName(): string;

    public function getField(): string;

    public function getOperator(): string;

    public function getValue(): mixed;

    public function setValue(mixed $value): void;

    public function apply(string $query): string;
}
