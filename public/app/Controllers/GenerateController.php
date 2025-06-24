<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Router\RouteAttribute;
use Faker\Factory;
use Faker\Generator;
use RuntimeException;

class GenerateController extends Controller
{
    private Generator $faker;
    private const string CSV_FILE_PATH = __DIR__ . '/../../../data/users.csv';

    public function __construct()
    {
        if (! class_exists('\Faker\Factory')) {
            throw new RuntimeException('Faker library is not installed. Please run: composer require fakerphp/faker');
        }
        $this->faker = Factory::create('en_US');
    }

    #[RouteAttribute('GET', '/generate')]
    public function index(): void
    {
        $this->render('generate/index');
    }

    #[RouteAttribute('POST', '/generate')]
    public function generate(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['quantity'])) {
            $quantity = (int)$_POST['quantity'];
            if ($quantity > 0) {
                try {
                    $filePath = $this->handleFileUpload();
                    $this->generateCsv($quantity, $filePath);
                    $this->downloadFile($filePath);

                    return;
                } catch (RuntimeException $e) {
                    error_log('Error generating CSV: ' . $e->getMessage());
                    $_SESSION['error'] = 'Failed to generate CSV file: ' . $e->getMessage();
                    $this->redirect('/generate');
                }
            }
        }

        $this->redirect('/generate');
    }

    private function handleFileUpload(): string
    {
        $dir = dirname(self::CSV_FILE_PATH);
        if (! is_dir($dir)) {
            if (! mkdir($dir, 0777, true)) {
                throw new RuntimeException('Failed to create directory: ' . $dir);
            }
        }

        if (! is_writable($dir)) {
            throw new RuntimeException('Directory is not writable: ' . $dir);
        }

        if (isset($_FILES['csv_file']) && $_FILES['csv_file']['error'] === UPLOAD_ERR_OK) {
            $uploadedFile = $_FILES['csv_file']['tmp_name'];
            if (! move_uploaded_file($uploadedFile, self::CSV_FILE_PATH)) {
                throw new RuntimeException('Failed to move uploaded file');
            }
        }

        return self::CSV_FILE_PATH;
    }

    private function generateCsv(int $quantity, string $filePath): void
    {
        $file = fopen($filePath, 'w');
        $error = error_get_last();
        if (! $file) {
            $message = $error['message'] ?? 'Unknown error';

            throw new RuntimeException('Failed to open CSV file for writing: ' . $message);
        }

        fputcsv($file, [
            'country',
            'city',
            'is_active',
            'gender',
            'birth_date',
            'salary',
            'has_children',
            'family_status',
            'registration_date',
        ]);

        for ($i = 0; $i < $quantity; $i++) {
            fputcsv($file, [
                $this->faker->country(),
                $this->faker->city(),
                $this->faker->boolean() ? 'yes' : 'no',
                $this->faker->randomElement(['male', 'female']),
                $this->faker->date('Y-m-d', '-30 years'),
                $this->faker->numberBetween(30000, 150000),
                $this->faker->boolean() ? 'yes' : 'no',
                $this->faker->randomElement(['single', 'married', 'divorced']),
                $this->faker->date('Y-m-d', '-5 years'),
            ]);
        }

        fclose($file);
    }

    private function downloadFile(string $filePath): void
    {
        if (file_exists($filePath)) {
            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename="users.csv"');
            header('Content-Length: ' . filesize($filePath));
            readfile($filePath);
            exit;
        }
    }
}
