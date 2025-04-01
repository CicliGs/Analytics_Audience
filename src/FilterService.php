<?php

namespace Src;

class FilterService
{
    public static function getFilters(): array
    {
        return [
            'country' => $_GET['country'] ?? '',
            'city' => $_GET['city'] ?? '',
            'isActive' => $_GET['isActive'] ?? '',
            'gender' => $_GET['gender'] ?? '',
            'birthDateStart' => $_GET['birthDateStart'] ?? '',
            'birthDateEnd' => $_GET['birthDateEnd'] ?? '',
            'salaryMin' => $_GET['salaryMin'] ?? '',
            'salaryMax' => $_GET['salaryMax'] ?? '',
            'hasChildren' => $_GET['hasChildren'] ?? '',
            'familyStatus' => $_GET['familyStatus'] ?? '',
            'registrationDateStart' => $_GET['registrationDateStart'] ?? '',
            'registrationDateEnd' => $_GET['registrationDateEnd'] ?? '',
        ];
    }
}
?>