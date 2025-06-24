<?php

declare(strict_types=1);

namespace App\Services;

use Faker\Factory;
use Faker\Generator;
use RuntimeException;

class CsvGeneratorService
{
    private Generator $faker;
    private string $filePath;

    public function __construct()
    {
        $this->filePath = __DIR__ . '/../../../data/users.csv';
        if (! class_exists('Faker\\Factory')) {
            throw new RuntimeException('Faker library is not installed. Please run: composer require fakerphp/faker');
        }
        $this->faker = Factory::create('en_US');
    }

    public function generate(int $quantity): string
    {
        $dir = dirname($this->filePath);
        if (! is_dir($dir)) {
            if (! mkdir($dir, 0777, true)) {
                throw new RuntimeException('Failed to create directory: ' . $dir);
            }
        }
        if (! is_writable($dir)) {
            throw new RuntimeException('Directory is not writable: ' . $dir);
        }

        $file = fopen($this->filePath, 'w');
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

        return $this->filePath;
    }

    public function getFilePath(): string
    {
        return $this->filePath;
    }
}
