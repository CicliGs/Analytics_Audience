<?php
namespace Src;

use PDO;

class UserRepository
{
    private $pdo;

    private const CSV_INDEX_IS_ACTIVE = 2;
    private const CSV_HAS_CHILDREN = 6;
    private const CSV_LENGTH = 1000;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function importFromCsv(string $csvFile): void
    {
        $file = fopen($csvFile, 'r');
        if (!$file) {
            throw new \Exception("Failed to open CSV file.");
        }

        fgetcsv($file);

        while (($data = fgetcsv($file, self::CSV_LENGTH, ',')) !== FALSE) {
            $data[2] = ($data[self::CSV_INDEX_IS_ACTIVE] === 'true') ? 1 : 0;
            $data[6] = ($data[self::CSV_HAS_CHILDREN] === 'true') ? 1 : 0;

            $stmt = $this->pdo->prepare("INSERT INTO users (country, city, isActive, gender, birthDate, salary, hasChildren, familyStatus, registrationDate) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute($data);
        }

        fclose($file);
    }

    public function filterUsers(array $filters): array
    {
        $sql = "SELECT * FROM users WHERE 1=1";
        $params = [];

        foreach ($filters as $key => $value) {
            if (!empty($value)) {
                switch ($key) {
                    case 'country':
                    case 'city':
                    case 'gender':
                    case 'familyStatus':
                        $sql .= " AND $key = ?";
                        $params[] = $value;
                        break;
                    case 'isActive':
                    case 'hasChildren':
                        $sql .= " AND $key = ?";
                        $params[] = (int)$value;
                        break;
                    case 'birthDateStart':
                        $sql .= " AND birthDate >= ?";
                        $params[] = $value;
                        break;
                    case 'birthDateEnd':
                        $sql .= " AND birthDate <= ?";
                        $params[] = $value;
                        break;
                    case 'salaryMin':
                        $sql .= " AND salary >= ?";
                        $params[] = $value;
                        break;
                    case 'salaryMax':
                        $sql .= " AND salary <= ?";
                        $params[] = $value;
                        break;
                    case 'registrationDateStart':
                        $sql .= " AND registrationDate >= ?";
                        $params[] = $value;
                        break;
                    case 'registrationDateEnd':
                        $sql .= " AND registrationDate <= ?";
                        $params[] = $value;
                        break;
                }
            }
        }

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
