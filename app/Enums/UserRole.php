<?php

declare(strict_types=1);

namespace App\Enums;

use App\Concerns\Enums\Arrayable;
use App\Concerns\Enums\Comparable;
use App\Concerns\Enums\HasLabel;

enum UserRole: string
{
    use Arrayable;
    use Comparable;
    use HasLabel;

    case SUPERADMIN = 'superadmin';
    case SUPERMANAGER = 'supermanager';
    case ADMIN = 'admin';
    case MANAGER = 'manager';
    case USER = 'user';

    public function labelKeyPrefix(): string
    {
        return 'user.roles';
    }
}
