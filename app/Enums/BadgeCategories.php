<?php

declare(strict_types=1);

namespace App\Enums;

use App\Concerns\Enums\Arrayable;
use App\Concerns\Enums\Comparable;
use App\Concerns\Enums\HasLabel;

enum BadgeCategories: string
{
    use Arrayable;
    use Comparable;
    use HasLabel;

    case DONATIONS = 'donations';

    case VOLUNTEERS = 'volunteers';

    case SHARING = 'sharing';

    case PROJECTS_ONG = 'projects_ong';

    case MONTH_ACTIVITY = 'month_activity';

    public function labelKeyPrefix(): string
    {
        return 'badge.categories';
    }
}
