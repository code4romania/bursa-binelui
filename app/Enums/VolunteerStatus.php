<?php

declare(strict_types=1);

namespace App\Enums;

use App\Concerns\ArrayableEnum;

enum VolunteerStatus: string
{
    use ArrayableEnum;
    case PENDING = 'pending';
    case APPROVED = 'approved';
    case REJECTED = 'rejected';
    public function translationKeyPrefix(): string
    {
        return 'volunteer.statuses';
    }
}
