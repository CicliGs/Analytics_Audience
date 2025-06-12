<?php

declare(strict_types=1);

namespace App;

use App\Filter\FilterPoolInterface;
use PDO;

class UserRepository
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
            throw new \RuntimeException('Database query failed.');
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
