<?php

declare(strict_types=1);

namespace App\Config;

use App\Filter\FilterApplier;
use App\Filter\FilterPool;
use App\Filter\FilterPoolInterface;
use App\Filter\FilterRegistry;
use App\Filter\FilterStorage;
use PDO;

class Application
{
    private ?PDO $connection = null;
    private ?FilterPoolInterface $filterPool = null;

    public function getConnection(): PDO
    {
        if ($this->connection === null) {
            $config = new DatabaseConfig();
            $this->connection = new PDO(
                $config->getDsn(),
                $config->getUsername(),
                $config->getPassword(),
                $config->getOptions()
            );
        }

        return $this->connection;
    }

    public function getFilterPool(): FilterPoolInterface
    {
        if ($this->filterPool === null) {
            $filterStorage = new FilterStorage();
            $filterApplier = new FilterApplier($filterStorage);
            $this->filterPool = new FilterPool($filterStorage, $filterApplier);

            $filterRegistry = new FilterRegistry($this->filterPool);
            $filterRegistry->register();
        }

        return $this->filterPool;
    }
}
