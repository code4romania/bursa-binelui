<?php

declare(strict_types=1);

namespace App\Enums;

use App\Concerns\Enums\Arrayable;
use App\Concerns\Enums\Comparable;
use App\Concerns\Enums\HasLabel;

enum OrganizationStatus: string
{
    use Arrayable;
    use Comparable;
    use HasLabel;

    case draft = 'draft';
    case pending = 'pending';
    case approved = 'active';
    case rejected = 'disabled';
    case pending_changes = 'pending_changes';

    protected function labelKeyPrefix(): ?string
    {
        return 'organization.status_arr';
    }
}
