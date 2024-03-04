<?php

declare(strict_types=1);

namespace App\Enums;

use App\Concerns\Enums\Arrayable;
use App\Concerns\Enums\Comparable;
use App\Concerns\Enums\HasLabel;

enum ProjectArea: string
{
    use Arrayable;
    use Comparable;
    use HasLabel;

    case LOCAL = 'local';
    case REGIONAL = 'regional';
    case NATIONAL = 'national';

    public function labelKeyPrefix(): string
    {
        return 'edition.labels.areas';
    }
}
