<?php

declare(strict_types=1);

namespace App\Enums;

use App\Concerns\ArrayableEnum;

enum UserRole: string
{
    use ArrayableEnum;
    case donor = 'donor';
    case ngo_admin = 'ngo-admin';
    case bb_manager = 'bb-manager';
    case bb_admin = 'bb-admin';

    public function translationKeyPrefix(): string
    {
        return 'user.roles';
    }
}
