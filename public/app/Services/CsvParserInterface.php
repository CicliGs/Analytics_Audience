<?php

declare(strict_types=1);

namespace App\Services;

interface CsvParserInterface
{
    /**
     * @return array<int, array<string, string>>
     */
    public function parse(string $filePath): array;
}
