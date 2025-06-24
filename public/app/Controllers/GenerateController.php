<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Router\RouteAttribute;
use App\Services\CsvGeneratorService;
use App\Services\FileService;
use RuntimeException;

class GenerateController extends Controller
{
    public function __construct(
        private readonly CsvGeneratorService $csvGenerator,
        private readonly FileService $fileService
    ) {
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
                    $filePath = $this->csvGenerator->generate($quantity);
                    $this->fileService->download($filePath);

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

    #[RouteAttribute('GET', '/generate/download')]
    public function download(): void
    {
        $filePath = $this->csvGenerator->getFilePath();
        $this->fileService->download($filePath);
    }
}
