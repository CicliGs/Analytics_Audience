<?php

declare(strict_types=1);

namespace Core\Handler;

use App\CsvImporter;
use App\UserRepository;
use Core\csv\CsvParserInterface;

class ParseHandler implements HandlerInterface
{
    private UserRepository  $userRepository;
    private CsvParserInterface $csvParser;
    private CsvImporter $csvImporter;

    public function __construct(
        UserRepository $userRepository,
        CsvParserInterface $csvParser,
        CsvImporter $csvImporter
    ) {
        $this->userRepository = $userRepository;
        $this->csvParser = $csvParser;
        $this->csvImporter = $csvImporter;
    }

    public function handle(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['csv_file'])) {
            $file = $_FILES['csv_file'];

            if ($file['error'] === UPLOAD_ERR_OK) {
                $data = $this->csvParser->parse($file['tmp_name']);
                $this->csvImporter->importFromCsv($file['tmp_name']);

                require __DIR__ . '/../../app/templates/parse_success.php';

                return;
            }
        }
        require __DIR__ . '/../../app/templates/header.php';
        require __DIR__ . '/../../app/templates/parse_form.php';
    }
}
