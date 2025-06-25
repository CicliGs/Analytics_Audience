<?php

declare(strict_types=1);

namespace App\Config;

class DatabaseConfig
{
    private const string DB_HOST = 'db';
    private const string DB_NAME = 'users';
    private const string DB_USER = 'postgres';
    private const string DB_PASS = 'postgres';
    private const int DB_PORT = 5432;

    public function getDsn(): string
    {
        return sprintf(
            'pgsql:host=%s;port=%d;dbname=%s',
            self::DB_HOST,
            self::DB_PORT,
            self::DB_NAME
        );
    }

    public function getUsername(): string
    {
        return self::DB_USER;
    }

    public function getPassword(): string
    {
        return self::DB_PASS;
    }

    /**
     * @return array<int, int|bool>
     */
    public function getOptions(): array
    {
        return [
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
            \PDO::ATTR_EMULATE_PREPARES => false,
        ];
    }
}
