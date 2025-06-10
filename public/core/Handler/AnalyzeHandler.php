<?php

declare(strict_types=1);

namespace Core\Handler;

use App\UserRepository;

class AnalyzeHandler implements HandlerInterface
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function handle(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            foreach ($_POST as $key => $value) {
                if ($filter = $this->userRepository->getFilterPool()->getFilter($key)) {
                    $filter->setValue($value);
                }
            }
        }

        $results = $this->userRepository->filterUsers();

        require __DIR__ . '/../../app/templates/results.php';
    }
}
