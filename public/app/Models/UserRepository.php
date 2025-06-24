<?php

declare(strict_types=1);

namespace App\Models;

use App\Filter\FilterPoolInterface;
use PDO;
use RuntimeException as RuntimeExceptionAlias;

readonly class UserRepository
{
    private const string DB_NAME = 'users';

    public function __construct(
        private PDO $connection,
        private FilterPoolInterface $filterPool
    ) {
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public function filterUsers(): array
    {
        $query = sprintf('SELECT * FROM %s', self::DB_NAME);
        $query = $this->filterPool->applyFilters($query);

        error_log('Final SQL query: ' . $query);

        $stmt = $this->connection->query($query);

        if ($stmt === false) {
            throw new RuntimeExceptionAlias('Database query failed.');
        }

        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return array_map([$this, 'mapDbRowToCamelCase'], $rows);
    }

    /**
     * @param array<string, mixed> $row
     * @return array<string, mixed>
     */
    private function mapDbRowToCamelCase(array $row): array
    {
        return [
            'country' => $row['country'] ?? '',
            'city' => $row['city'] ?? '',
            'isActive' => $row['is_active'] === 't' || $row['is_active'] === true,
            'gender' => $row['gender'] ?? '',
            'birthDate' => $row['birth_date'] ?? '',
            'salary' => $row['salary'] ?? '',
            'hasChildren' => $row['has_children'] === 't' || $row['has_children'] === true,
            'familyStatus' => $row['family_status'] ?? '',
            'registrationDate' => $row['registration_date'] ?? '',
        ];
    }

    public function getFilterPool(): FilterPoolInterface
    {
        return $this->filterPool;
    }
}
