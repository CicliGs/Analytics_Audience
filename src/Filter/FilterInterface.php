<?php

namespace Src\Filter;

interface FilterInterface{
    public function apply(array $filters, string $sql, array &$params): string;
    public function getFilterName(): string;
}