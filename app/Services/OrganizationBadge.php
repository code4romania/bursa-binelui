<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\BadgeCategories;
use App\Enums\BadgeRules;
use App\Enums\BadgeType;
use App\Models\Badge;
use App\Models\BadgeCategory;
use App\Models\BadgeOrganization;
use App\Models\Organization;

class OrganizationBadge
{
    public function updateOrganizationBadge(Organization $organization): void
    {
        $projectsCount = $organization->projects
            ->count();

        $badgeRule = $this->getBadgeRuleByProjectCount($projectsCount);

        if (! $badgeRule) {
            return;
        }

        $badgeCategory = BadgeCategory::query()
            ->where('title', BadgeCategories::PROJECTS_ONG)
            ->with('badges')
            ->first();

        if (! $badgeCategory->badges) {
            return;
        }

        $badges = $badgeCategory->badges
            ->filter(
                fn (Badge $item) => $item->type == BadgeType::AUTOMATED &&
                    $item->rule == $badgeRule->value
            );

        foreach ($badges as $badge) {
            $badgeOrganization = new BadgeOrganization();
            $badgeOrganization->organization_id = $organization->id;
            $badgeOrganization->badge_id = $badge->id;
            $badgeOrganization->save();
        }
    }

    private function getBadgeRuleByProjectCount(int $projectsCount): ?BadgeRules
    {
        $projectsRules = [1 => BadgeRules::PROJECT_FIRST_CREATED,
            2 => BadgeRules::PROJECT_TWO_CREATED,
            3 => BadgeRules::PROJECT_THREE_CREATED,
            5 => BadgeRules::PROJECT_FIVE_CREATED,

        ];

        return \in_array($projectsCount, array_keys($projectsRules)) ?
            $projectsRules[$projectsCount] :
            null;
    }
}
