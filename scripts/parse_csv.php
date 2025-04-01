<?php
require __DIR__ . '/../vendor/autoload.php';

use Src\Database;
use Src\UserRepository;

$database = new Database();
$userRepository = new UserRepository($database->getConnection());

try {
    $csvFile = __DIR__ . '/../data/data.csv';
    $userRepository->importFromCsv($csvFile);
    echo "Data imported successfully!";
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
