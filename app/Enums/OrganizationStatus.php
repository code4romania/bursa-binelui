<?php

declare(strict_types=1);

namespace App\Enums;

use App\Concerns\ArrayableEnum;

enum OrganizationStatus: string
{
    use ArrayableEnum;
    case draft = 'draft';
    case pending = 'pending';
    case approved = 'active';
    case rejected = 'disabled';
    case pending_changes = 'pending_changes';

    protected function translationKeyPrefix(): ?string
    {
        return 'organization.status_arr';
    }
}
