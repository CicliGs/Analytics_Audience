<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\UserRepository;
use App\Router\RouteAttribute;

class AnalyzeController extends Controller
{
    public function __construct(
        private readonly UserRepository $userRepository
    ) {
    }

    #[RouteAttribute('GET', '/analyze')]
    public function index(): void
    {
        $results = $this->userRepository->filterUsers();
        $this->render('analyze/index', ['results' => $results]);
    }

    #[RouteAttribute('POST', '/analyze')]
    public function filter(): void
    {
        foreach ($_POST as $key => $value) {
            if ($filter = $this->userRepository->getFilterPool()->getFilter($key)) {
                $filter->setValue($value);
            }
        }

        $results = $this->userRepository->filterUsers();
        $this->render('analyze/index', ['results' => $results]);
    }
}
