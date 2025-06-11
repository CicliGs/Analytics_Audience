<?php

declare(strict_types=1);

namespace Core\Handler;

use Faker\Factory;
use Faker\Generator;
use RuntimeException;

class GenerateHandler implements HandlerInterface
{
    private Generator $faker;
    private const string CSV_FILE_PATH = '/var/www/html/data/users.csv';

    public function __construct()
    {
        if (! class_exists('\Faker\Factory')) {
            throw new RuntimeException('Faker library is not installed. Please run: composer require fakerphp/faker');
        }
        $this->faker = Factory::create('en_US');
    }

    public function handle(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['quantity'])) {
            $quantity = (int)$_POST['quantity'];
            if ($quantity > 0) {
                $filePath = $this->handleFileUpload();
                $this->generateCsv($quantity, $filePath);
                $this->downloadFile($filePath);

                return;
            }
        }

        require __DIR__ . '/../../app/templates/generate_form.php';
    }

    private function handleFileUpload(): string
    {
        if (isset($_FILES['csv_file']) && $_FILES['csv_file']['error'] === UPLOAD_ERR_OK) {
            $uploadedFile = $_FILES['csv_file']['tmp_name'];
            $targetPath = self::CSV_FILE_PATH;

            // Ensure the data directory exists
            $dir = dirname($targetPath);
            if (! is_dir($dir)) {
                mkdir($dir, 0777, true);
            }

            // Move uploaded file to target location
            move_uploaded_file($uploadedFile, $targetPath);

            return $targetPath;
        }

        return self::CSV_FILE_PATH;
    }

    private function generateCsv(int $quantity, string $filePath): void
    {
        $file = fopen($filePath, 'w');
        if (! $file) {
            throw new RuntimeException('Failed to open CSV file for writing');
        }

        // Write header
        fputcsv($file, [
            'country',
            'city',
            'isActive',
            'gender',
            'birthDate',
            'salary',
            'hasChildren',
            'familyStatus',
            'registrationDate',
        ]);

        for ($i = 0; $i < $quantity; $i++) {
            $data = [
                $this->faker->country(),
                $this->faker->city(),
                $this->faker->boolean() ? '1' : '0',
                $this->faker->randomElement(['male', 'female']),
                $this->faker->date('Y-m-d', '-20 years'),
                $this->faker->numberBetween(30000, 150000),
                $this->faker->boolean() ? '1' : '0',
                $this->faker->randomElement(['single', 'married', 'divorced', 'widowed']),
                $this->faker->dateTimeBetween('-5 years')->format('Y-m-d'),
            ];
            fputcsv($file, $data);
        }

        fclose($file);
    }

    private function downloadFile(string $filePath): void
    {
        if (! file_exists($filePath)) {
            throw new RuntimeException('Generated file not found');
        }

        $fileName = basename($filePath);

        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $fileName . '"');
        header('Content-Length: ' . filesize($filePath));
        header('Cache-Control: no-cache, must-revalidate');
        header('Pragma: no-cache');
        header('Expires: 0');

        readfile($filePath);
        exit;
    }
}
