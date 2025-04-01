<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Src\Database;
use Src\UserRepository;
use Src\FilterService;
use Src\Filter\FilterPool;
use Src\Filter\IsActiveFilter;
use Src\Filter\HasChildrenFilter;
use Src\Filter\FamilyStatusFilter;
use Src\Filter\GenderFilter;
use Src\Filter\CityFilter;
use Src\Filter\CountryFilter;

$database = new Database();
$filterPool = new FilterPool();
$userRepository = new UserRepository($database->getConnection(), $filterPool);

$filterPool->addFilter(new IsActiveFilter());
$filterPool->addFilter(new HasChildrenFilter());
$filterPool->addFilter(new FamilyStatusFilter());
$filterPool->addFilter(new GenderFilter());
$filterPool->addFilter(new CityFilter());
$filterPool->addFilter(new CountryFilter());

$filters = FilterService::getFilters();
$results = $userRepository->filterUsers($filters);

require_once __DIR__ . '/../templates/results.php';
?>