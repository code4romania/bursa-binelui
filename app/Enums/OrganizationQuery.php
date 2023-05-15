<?php

declare(strict_types=1);

namespace App\Enums;

enum OrganizationQuery: string
{
    case activity_domain = 'ad';
    case cities = 'c';
    case search = 's';
}
