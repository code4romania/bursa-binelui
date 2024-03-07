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

    case DONATIONS = 'Donatii';

    case VOLUNTEERS = 'Voluntariat';

    case SHARING = 'Sharing';

    case PROJECTS_ONG = 'Proiect ONG';

    case MONTH_ACTIVITY = 'Activitate lunara';

    public function labelKeyPrefix(): string
    {
        return 'badge.categories';
    }
}
