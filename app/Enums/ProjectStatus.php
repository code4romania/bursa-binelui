<?php

declare(strict_types=1);

namespace App\Enums;

use App\Concerns\ArrayableEnum;

enum ProjectStatus: string
{
    use ArrayableEnum;
    case draft = 'draft';
    case pending = 'pending';
    case change_request = 'change_request';
    case approved = 'approved';
    case rejected = 'rejected';
    case active = 'active';
    case disabled = 'disabled';


    protected function translationKeyPrefix(): ?string
    {
        return 'project.status_arr';
    }
}
