<?php

declare(strict_types=1);

namespace App\Enums;

use App\Concerns\Enums\Arrayable;
use App\Concerns\Enums\Comparable;
use App\Concerns\Enums\HasLabel;

enum GalaProjectStatus: string
{
    use Arrayable;
    use Comparable;
    use HasLabel;

    case draft = 'draft';
    case publish = 'published';

    protected function labelKeyPrefix(): ?string
    {
        return 'project.gala_project_status_ar';
    }
}
