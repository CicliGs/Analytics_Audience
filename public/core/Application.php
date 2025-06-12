<?php

declare(strict_types=1);

namespace Core;

use App\Filter\FilterInteraction\FilterPool;
use App\Filter\FilterRegistry;
use App\UserRepository;
use Core\csv\CsvParser;
use Core\Database\DatabaseConfig;
use Dotenv\Dotenv;
use PDO;

class Application
{
    public static Application $app;
    private UserRepository $userRepository;
    private FilterPool $filterPool;
    private PDO $connection;

    public function __construct()
    {
        self::$app = $this;
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
        $dotenv->load();

        $this->initializeDatabase();
        $this->initializeFilters();
        $this->initializeRepositories();
    }

    private function initializeDatabase(): void
    {
        $config = new DatabaseConfig();
        $this->connection = new PDO(
            $config->getDsn(),
            $config->getUsername(),
            $config->getPassword(),
            $config->getOptions()
        );
    }

    private function initializeFilters(): void
    {
        $this->filterPool = new FilterPool();
        $registry = new FilterRegistry($this->filterPool);
        $registry->register();
    }

    private function initializeRepositories(): void
    {
        $csvParser = new CsvParser();
        $this->userRepository = new UserRepository(
            $this->connection,
            $this->filterPool,
            $csvParser
        );
    }

    public function handleRequest(array $request): array
    {
        foreach ($request as $key => $value) {
            if ($filter = $this->filterPool->getFilter($key)) {
                $filter->setValue($value);
            }
        }

        return $this->userRepository->filterUsers();
    }

    public function getUserRepository(): UserRepository
    {
        return $this->userRepository;
    }
}
