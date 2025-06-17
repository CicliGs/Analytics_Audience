<?php

declare(strict_types=1);

namespace Core\Handler;

use App\UserRepository;

readonly class AnalyzeHandler implements HandlerInterface
{
    public function __construct(
        private UserRepository $userRepository
    ) {
    }

    public function handle(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            error_log('POST data received: ' . print_r($_POST, true));

            foreach ($_POST as $key => $value) {
                if ($filter = $this->userRepository->getFilterPool()->getFilter($key)) {
                    error_log(sprintf('Applying filter for %s with value %s', $key, $value));
                    $filter->setValue($value);
                } else {
                    error_log(sprintf('No filter found for %s', $key));
                }
            }
        }

        $results = $this->userRepository->filterUsers();
        error_log('Query results: ' . print_r($results, true));

        require __DIR__ . '/../../app/templates/results.php';
    }
}
