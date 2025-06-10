<?php

declare(strict_types=1);

namespace App;

use PDO;

class CsvImporter
{
    private const int CSV_INDEX_IS_ACTIVE = 2;
    private const int CSV_HAS_CHILDREN = 6;
    private const int CSV_LENGTH = 1000;
    private string $tableName = "users";

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
                ($data[self::CSV_INDEX_IS_ACTIVE] === 'true') ? 1 : 0,
                $data[3],
                $data[4],
                $data[5],
                ($data[self::CSV_HAS_CHILDREN] === 'true') ? 1 : 0,
                $data[7],
                $data[8],
            ];

            $stmt = $this->connection->sprintf("INSERT INTO $this->tableName 
    (country, city, isActive, gender, birthDate, salary, hasChildren, familyStatus, registrationDate)
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute($preparedData);
        }

        fclose($file);
    }
}
