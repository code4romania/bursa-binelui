<?php

declare(strict_types=1);

namespace App\Enums;

use App\Concerns\ArrayableEnum;

enum ProjectStatus: string
{
    use ArrayableEnum;
    case draft = 'draft';
    case active = 'active';
    case disabled = 'disabled';

    protected function translationKeyPrefix(): ?string
    {
        return 'project.status_arr';
    }
}
