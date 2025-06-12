<?php

declare(strict_types=1);

namespace App;

use App\Filter\FilterData;
use App\Filter\FilterInteraction\FilterPoolInterface;
use Core\csv\CsvParserInterface;
use PDO;
use PDOStatement;

class UserRepository
{
    private PDO $connection;
    private FilterPoolInterface $filterPool;
    private CsvParserInterface $csvParser;

    private const int CSV_INDEX_IS_ACTIVE = 2;
    private const int CSV_HAS_CHILDREN = 6;
    private const int CSV_LENGTH = 1000;
    private const string CSV_DELIMITER = ',';

    public function __construct(
        PDO $connection, 
        FilterPoolInterface $filterPool,
        CsvParserInterface $csvParser
    ) {
        $this->connection = $connection;
        $this->filterPool = $filterPool;
        $this->csvParser = $csvParser;
    }

    public function importFromCsv(string $csvFile): void
    {
        $data = $this->csvParser->parse($csvFile);
        $stmt = $this->prepareInsertStatement();

        foreach ($data as $row) {
            $stmt->execute($row);
        }
    }

    public function filterUsers(): array
    {
        $query = "SELECT * FROM users";
        $query = $this->filterPool->applyFilters($query);
        
        $stmt = $this->connection->query($query);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return array_map([$this, 'mapDbRowToCamelCase'], $rows);
    }

    private function mapDbRowToCamelCase(array $row): array
    {
        return [
            'country' => $row['country'] ?? '',
            'city' => $row['city'] ?? '',
            'isActive' => $row['isactive'] ?? null,
            'gender' => $row['gender'] ?? '',
            'birthDate' => $row['birthdate'] ?? '',
            'salary' => $row['salary'] ?? '',
            'hasChildren' => $row['haschildren'] ?? null,
            'familyStatus' => $row['familystatus'] ?? '',
            'registrationDate' => $row['registrationdate'] ?? '',
        ];
    }

    private function prepareInsertStatement(): PDOStatement
    {
        return $this->connection->prepare(sprintf(
            "INSERT INTO users (
                country, city, isActive, gender, birthDate, 
                salary, hasChildren, familyStatus, registrationDate
            ) VALUES (%s)",
            implode(', ', array_fill(0, 9, '?'))
        ));
    }

    private function processCsvRow(array $data, PDOStatement $stmt): void
    {
        $data[self::CSV_INDEX_IS_ACTIVE] = $this->convertBooleanToInt($data[self::CSV_INDEX_IS_ACTIVE]);
        $data[self::CSV_HAS_CHILDREN] = $this->convertBooleanToInt($data[self::CSV_HAS_CHILDREN]);

        $stmt->execute($data);
    }

    private function convertBooleanToInt(string $value): int
    {
        return ($value === 'true') ? 1 : 0;
    }
}
