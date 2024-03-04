<?php

declare(strict_types=1);

namespace App\Enums;

use App\Concerns\Enums\Arrayable;
use App\Concerns\Enums\Comparable;
use App\Concerns\Enums\HasLabel;

enum OrganizationType: string
{
    use Arrayable;
    use Comparable;
    use HasLabel;

    case LITTLE = 'little';
    case MEDIUM = 'medium';
    case BIG = 'big';

    public function labelKeyPrefix(): string
    {
        return 'edition.labels.organization_types';
    }
}
