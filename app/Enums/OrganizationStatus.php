<?php

declare(strict_types=1);

namespace App\Enums;

use App\Concerns\ArrayableEnum;

enum OrganizationStatus: string
{
    use ArrayableEnum;
    case pending = 'pending';
    case approved = 'active';
    case rejected = 'disabled';

    public const pending_changes = 'pending_changes';

    protected function translationKeyPrefix(): ?string
    {
        return 'organization.status_arr';
    }
}
