<?php

declare(strict_types=1);

namespace App\Enums;

enum UserRole: string
{
    case donor = 'donor';
    case ngo_admin = 'ngo-admin';
    case bb_manager = 'bb-manager';
    case bb_admin = 'bb-admin';
}
