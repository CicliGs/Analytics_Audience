<?php

declare(strict_types=1);

namespace App;

use PDO;

class CsvImporter
{
    private const CSV_INDEX_IS_ACTIVE = 2;
    private const CSV_HAS_CHILDREN = 6;
    private const CSV_LENGTH = 1000;

    public function __construct(
        private PDO $connection
    ) {
    }

    public function importFromCsv(string $csvFile): void
    {
        $file = fopen($csvFile, 'r');
        if (! $file) {
            throw new \Exception("Failed to open CSV file.");
        }

        fgetcsv($file);

        while (($data = fgetcsv($file, self::CSV_LENGTH, ',')) !== false) {
            if (count($data) < 9) {
                continue;
            }

            $preparedData = [
                $data[0],
                $data[1],
                $this->convertToPostgresBoolean($data[self::CSV_INDEX_IS_ACTIVE]),
                $data[3],
                $data[4],
                $data[5],
                $this->convertToPostgresBoolean($data[self::CSV_HAS_CHILDREN]),
                $data[7],
                $data[8],
            ];

            $stmt = $this->connection->prepare("INSERT INTO users 
    (country, city, isActive, gender, birthDate, salary, hasChildren, familyStatus, registrationDate)
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute($preparedData);
        }

        fclose($file);
    }

    private function convertToPostgresBoolean(string $value): string
    {
        $value = strtolower($value);

        return in_array($value, ['true', '1', 'yes'], true) ? 't' : 'f';
    }
}
