<?php

declare(strict_types=1);

namespace Core\Handler;

use App\CsvImporter;
use App\UserRepository;
use Core\csv\CsvParserInterface;
use RuntimeException;

readonly class HandlerFactory implements HandlerFactoryInterface
{
    public function __construct(
        private UserRepository     $userRepository,
        private CsvParserInterface $csvParser,
        private CsvImporter        $csvImporter
    ) {
    }

    public function createHandler(string $handlerName): HandlerInterface
    {
        return match ($handlerName) {
            'analyze' => new AnalyzeHandler($this->userRepository),
            'parse' => new ParseHandler($this->csvParser, $this->csvImporter),
            'generate' => new GenerateHandler(),
            default => throw new RuntimeException('Unknown handler: ' . $handlerName),
        };
    }
}
