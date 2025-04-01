<?php
namespace Src;

use PDO;
use Src\Filter\FilterPool;

class UserRepository
{
    private $pdo;
    private FilterPool $filterPool;

    private const CSV_INDEX_IS_ACTIVE = 2;
    private const CSV_HAS_CHILDREN = 6;
    private const CSV_LENGTH = 1000;

    public function __construct(PDO $pdo, FilterPool $filterPool)
    {
        $this->pdo = $pdo;
        $this->filterPool = $filterPool;
    }

    public function importFromCsv(string $csvFile): void
    {
        $file = fopen($csvFile, 'r');
        if (!$file) {
            throw new \Exception("Failed to open CSV file.");
        }

        fgetcsv($file);

        while (($data = fgetcsv($file, self::CSV_LENGTH, ',')) !== FALSE) {
            $data[self::CSV_INDEX_IS_ACTIVE] = ($data[self::CSV_INDEX_IS_ACTIVE] === 'true') ? 1 : 0;
            $data[self::CSV_HAS_CHILDREN] = ($data[self::CSV_HAS_CHILDREN] === 'true') ? 1 : 0;

            $stmt = $this->pdo->prepare("INSERT INTO users (country, city, isActive, gender, birthDate, salary, hasChildren, familyStatus, registrationDate) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute($data);
        }

        fclose($file);
    }

    public function filterUsers(array $filters): array
    {
        $sql = "SELECT * FROM users";
        $params = [];

        $sql = $this->filterPool->applyFilters($filters, $sql, $params);

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
