<?php

declare(strict_types=1);

namespace Core\Handler;

use App\UserRepository;
use Core\csv\CsvParserInterface;

class ParseHandler implements HandlerInterface
{
    private UserRepository $userRepository;
    private CsvParserInterface $csvParser;

    public function __construct(UserRepository $userRepository, CsvParserInterface $csvParser)
    {
        $this->userRepository = $userRepository;
        $this->csvParser = $csvParser;
    }

    public function handle(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['csv_file'])) {
            $file = $_FILES['csv_file'];

            if ($file['error'] === UPLOAD_ERR_OK) {
                $data = $this->csvParser->parse($file['tmp_name']);
                $this->userRepository->importFromCsv($file['tmp_name']);

                require __DIR__ . '/../../app/templates/parse_success.php';

                return;
            }
        }

        require __DIR__ . '/../../app/templates/parse_form.php';
    }
}
