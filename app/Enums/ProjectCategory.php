<?php

declare(strict_types=1);

namespace App\Enums;

use App\Concerns\ArrayableEnum;

enum ProjectCategory: string
{
    use ArrayableEnum;
    case SocialEntrepreneurship = 'social-entrepreneurship';
    case HumanRights = 'human-rights';
    case Education = 'education';
    case Environment = 'environment';
    case AnimalProtection = 'animal-protection';
    case Health = 'health';
    case Social = 'social';
    case Sport = 'sport';

    protected function translationKeyPrefix(): ?string
    {
        return 'project.categories';
    }
}
