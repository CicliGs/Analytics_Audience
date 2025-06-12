<?php

declare(strict_types=1);

namespace Core;

use App\Filter\FilterPool;
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
    private FilterRegistry $filterRegistry;
    private CsvParser $csvParser;

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
        $this->filterRegistry = new FilterRegistry($this->filterPool);
        $this->filterRegistry->register();
    }

    private function initializeRepositories(): void
    {
        $this->csvParser = new CsvParser();
        $this->userRepository = new UserRepository(
            $this->connection,
            $this->filterPool
        );
    }

    public function getUserRepository(): UserRepository
    {
        return $this->userRepository;
    }

    public function getCsvParser(): CsvParser
    {
        return $this->csvParser;
    }

    public function getConnection(): PDO
    {
        return $this->connection;
    }
}
