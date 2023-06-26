<?php

declare(strict_types=1);

namespace App\Enums;

use App\Concerns\ArrayableEnum;

enum OrganizationStatus: string
{
    use ArrayableEnum;
    case pending = 'pending';
    case active = 'active';
    case disabled = 'disabled';

    protected function translationKeyPrefix(): ?string
    {
        return 'organization.status_arr';
    }
}
