<?php

declare(strict_types=1);

namespace Core\csv;

class CsvParser implements CsvParserInterface
{
    private const CSV_LENGTH = 1000;
    private const CSV_DELIMITER = ',';

    /**
     * @return array<int, array<string, mixed>>
     */
    public function parse(string $filePath): array
    {
        $file = fopen($filePath, 'r');
        if (! $file) {
            throw new \RuntimeException(sprintf('Failed to open CSV file: %s', $filePath));
        }

        try {
            fgetcsv($file, self::CSV_LENGTH, self::CSV_DELIMITER);

            $data = [];
            while (($row = fgetcsv($file, self::CSV_LENGTH, self::CSV_DELIMITER)) !== false) {
                $data[] = $this->processRow($row);
            }

            return $data;
        } finally {
            fclose($file);
        }
    }

    /**
     * @param array<int, string|null> $row
     * @return array<string, mixed>
     */
    private function processRow(array $row): array
    {
        return [
            'country' => $row[0] ?? '',
            'city' => $row[1] ?? '',
            'isactive' => $this->convertBooleanToInt($row[2] ?? ''),
            'gender' => $row[3] ?? '',
            'birthdate' => $row[4] ?? '',
            'salary' => $row[5] ?? '',
            'haschildren' => $this->convertBooleanToInt($row[6] ?? ''),
            'familystatus' => $row[7] ?? '',
            'registrationdate' => $row[8] ?? '',
        ];
    }

    private function convertBooleanToInt(string $value): int
    {
        $value = strtolower($value);

        return in_array($value, ['true', '1', 'yes'], true) ? 1 : 0;
    }
}
