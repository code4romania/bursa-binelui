<?php

declare(strict_types=1);

namespace App\Enums;

enum OrganizationStatus: string
{
    case pending = 'pending';
    case active = 'active';
    case disabled = 'disabled';
}
