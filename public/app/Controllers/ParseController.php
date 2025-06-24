<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Router\RouteAttribute;
use App\Services\CsvImporter;

class ParseController extends Controller
{
    public function __construct(
        private readonly CsvImporter $csvImporter
    ) {
    }

    #[RouteAttribute('GET', '/parse')]
    public function index(): void
    {
        $this->render('parse/index');
    }

    #[RouteAttribute('POST', '/parse')]
    public function upload(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (empty($_FILES['csv_file']) ||
                (isset($_FILES['csv_file']['error']) &&
                ($_FILES['csv_file']['error'] === UPLOAD_ERR_INI_SIZE || $_FILES['csv_file']['error'] === UPLOAD_ERR_FORM_SIZE))) {
                $_SESSION['error'] = 'Файл слишком большой. Максимальный размер — 5 МБ.';

                return;
            }

            $file = $_FILES['csv_file'];

            if ($file['size'] > 5 * 1024 * 1024) {
                $_SESSION['error'] = 'Файл слишком большой. Максимальный размер — 5 МБ.';

                return;
            }

            if ($file['error'] === UPLOAD_ERR_OK) {
                $this->csvImporter->importFromCsv($file['tmp_name']);
                $this->render('parse/success');

                return;
            }
        }

        $this->redirect('/parse');
    }

    #[RouteAttribute('GET', '/parse/success')]
    public function success(): void
    {
        $this->render('parse/success');
    }
}
