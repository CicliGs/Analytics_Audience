<?php

declare(strict_types=1);

namespace App\Services;

class FileService
{
    public function download(string $filePath): void
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
