<?php

declare(strict_types=1);

namespace App;

use App\Filter\FilterInteraction\FilterPoolInterface;
use PDO;

class UserRepository
{
    private PDO $connection;
    private FilterPoolInterface $filterPool;

    private string $tableName = 'users';

    public function __construct(
        PDO $connection,
        FilterPoolInterface $filterPool
    ) {
        $this->connection = $connection;
        $this->filterPool = $filterPool;
    }

    public function filterUsers(): array
    {
        $query = sprintf("SELECT * FROM $this->tableName");
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

    public function getFilterPool(): FilterPoolInterface
    {
        return $this->filterPool;
    }
}
