<?php
require __DIR__ . '/../vendor/autoload.php';

use Src\Database;
use Src\UserRepository;
use Src\FilterService;

$database = new Database();
$userRepository = new UserRepository($database->getConnection());

$filters = FilterService::getFilters();
$results = $userRepository->filterUsers($filters);

include __DIR__ . '/../templates/results.php';
?>
