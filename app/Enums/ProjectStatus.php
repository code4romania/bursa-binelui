<?php

declare(strict_types=1);

namespace App\Enums;

use App\Concerns\Enums\Arrayable;
use App\Concerns\Enums\Comparable;
use App\Concerns\Enums\HasLabel;

enum ProjectStatus: string
{
    use Arrayable;
    use Comparable;
    use HasLabel;

    case draft = 'draft';
    case pending = 'pending';
    case approved = 'approved';
    case rejected = 'rejected';
    case archived = 'archived';

    protected function labelKeyPrefix(): ?string
    {
        return 'project.status_arr';
    }
}
