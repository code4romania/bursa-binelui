<?php

declare(strict_types=1);

namespace App\Enums;

use App\Concerns\Enums\Arrayable;
use App\Concerns\Enums\Comparable;
use App\Concerns\Enums\HasLabel;

enum VolunteerStatus: string
{
    use Arrayable;
    use Comparable;
    use HasLabel;

    case PENDING = 'pending';
    case APPROVED = 'approved';
    case REJECTED = 'rejected';

    public function labelKeyPrefix(): string
    {
        return 'volunteer.statuses';
    }
}
