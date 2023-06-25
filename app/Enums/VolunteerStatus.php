<?php

declare(strict_types=1);

namespace App\Enums;

enum VolunteerStatus: string
{
    case pending = 'pending';
    case active = 'active';
    case inactive = 'inactive';
}
