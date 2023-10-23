<?php

declare(strict_types=1);

namespace App\Enums;

use App\Concerns\Enums\Arrayable;
use App\Concerns\Enums\Comparable;
use App\Concerns\Enums\HasLabel;

enum BadgeType: string
{
    use Arrayable;
    use Comparable;
    use HasLabel;

    case AUTOMATED = 'automated';
    case MANUAL = 'manual';

    public function labelKeyPrefix(): string
    {
        return 'badge.types';
    }
}
