<?php

declare(strict_types=1);

namespace Core\csv;

interface CsvParserInterface
{
    /**
    * @return array<int, array<string, mixed>>
    */
    public function parse(string $filePath): array;
}
