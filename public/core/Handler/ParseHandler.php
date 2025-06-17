<?php

declare(strict_types=1);

namespace Core\Handler;

use App\CsvImporter;
use Core\csv\CsvParserInterface;
use Exception;

readonly class ParseHandler implements HandlerInterface
{
    public function __construct(
        private CsvParserInterface $csvParser,
        private CsvImporter        $csvImporter
    ) {

    }

    public function handle(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['csv_file'])) {
            $file = $_FILES['csv_file'];

            if ($file['error'] === UPLOAD_ERR_OK) {
                $data = $this->csvParser->parse($file['tmp_name']);

                try {
                    $this->csvImporter->importFromCsv($file['tmp_name']);
                } catch (Exception $e) {

                }

                require __DIR__ . '/../../app/templates/parse_success.php';

                return;
            }
        }
        require __DIR__ . '/../../app/templates/header.php';
        require __DIR__ . '/../../app/templates/parse_form.php';
    }
}
