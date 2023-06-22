<?php

declare(strict_types=1);

namespace App\Enums;

enum EuPlatescStatus: string
{
    case padding = 'padding';
    case in_progress = 'in-progress';
    case succeeded = 'succeeded';
}
