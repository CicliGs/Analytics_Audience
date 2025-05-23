<?php

namespace Core\Database;

use Dotenv\Dotenv;
use PDO;

class DatabaseConfig
{
    private string $host;
    private string $port;
    private string $database;
    private string $username;
    private string $password;
    private array $options;

    public function __construct()
    {
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../../..');
        $dotenv->load();

        $this->host = $_ENV['POSTGRES_HOST'];
        $this->port = $_ENV['POSTGRES_PORT'];
        $this->database = $_ENV['POSTGRES_DB'];
        $this->username = $_ENV['POSTGRES_USER'];
        $this->password = $_ENV['POSTGRES_PASSWORD'];
        $this->options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];
    }

    public function getDsn(): string
    {
        return sprintf(
            'pgsql:host=%s;port=%s;dbname=%s',
            $this->host,
            $this->port,
            $this->database
        );
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getOptions(): array
    {
        return $this->options;
    }
}
