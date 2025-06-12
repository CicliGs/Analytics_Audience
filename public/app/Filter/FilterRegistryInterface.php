<?php

declare(strict_types=1);

namespace App\Filter;

interface FilterRegistryInterface
{
    public function register(): void;
}
