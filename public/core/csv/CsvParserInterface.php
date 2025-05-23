<?php

declare(strict_types=1);

namespace Core\csv;

interface CsvParserInterface
{
    /**
     * Parse CSV file and return array of data
     * @param string $filePath Path to CSV file
     * @return array Array of parsed data
     * @throws \RuntimeException If file cannot be opened or read
     */
    public function parse(string $filePath): array;
} 