<?php

declare(strict_types=1);

namespace Core\csv;

interface CsvParserInterface
{
    public function parse(string $filePath): array;
}
