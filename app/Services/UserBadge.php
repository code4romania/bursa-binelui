<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\BadgeCategories;
use App\Enums\BadgeRules;
use App\Enums\BadgeType;
use App\Enums\EuPlatescStatus;
use App\Models\Badge;
use App\Models\BadgeCategory;
use App\Models\BadgeUser;
use App\Models\Donation;
use App\Models\User;

class UserBadge
{
    public function updateDonationBadge(User $user): void
    {
        $donationCount = $user->donations
            ->filter(fn (Donation $donation) => $donation->status == EuPlatescStatus::CAPTURE)
            ->count();

        $badgeRule = $this->getBadgeRuleByDonationCount($donationCount);

        if (! $badgeRule) {
            return;
        }

        $badgeCategory = BadgeCategory::query()
            ->where('title', BadgeCategories::DONATIONS)
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
            $badgeUser = new BadgeUser();
            $badgeUser->user_id = $user->id;
            $badgeUser->badge_id = $badge->id;
            $badgeUser->save();
        }
    }

    private function getBadgeRuleByDonationCount(int $donationCount): ?BadgeRules
    {
        $donationsRules = [1 => BadgeRules::DONATION_FIRST_COUNTER_DONATION,
            3 => BadgeRules::DONATION_THREE_COUNTER_DONATION,
            10 => BadgeRules::DONATION_TEN_COUNTER_DONATION,
            15 => BadgeRules::DONATION_FIFTEEN_COUNTER_DONATION,
            20 => BadgeRules::DONATION_TWENTY_COUNTER_DONATION,
            25 => BadgeRules::DONATION_TWENTY_FIVE_COUNTER_DONATION,
            30 => BadgeRules::DONATION_THIRTIETH_COUNTER_DONATION,
            35 => BadgeRules::DONATION_THIRTIETH_FIVE_COUNTER_DONATION,
            40 => BadgeRules::DONATION_FORTY_COUNTER_DONATION,
            45 => BadgeRules::DONATION_FORTY_FIVE_COUNTER_DONATION,
            50 => BadgeRules::DONATION_FIFTY_COUNTER_DONATION,
            100 => BadgeRules::DONATION_ONE_HUNDRED_AMOUNT_DONATION,
            500 => BadgeRules::DONATION_FIVE_HUNDRED_AMOUNT_DONATION,
            1000 => BadgeRules::DONATION_ONE_THOUSAND_AMOUNT_DONATION,
            1500 => BadgeRules::DONATION_ONE_THOUSAND_FIVE_HUNDRED_AMOUNT_DONATION,
            2000 => BadgeRules::DONATION_TWO_THOUSAND_AMOUNT_DONATION,
        ];

        return \in_array($donationCount, array_keys($donationsRules)) ?
            $donationsRules[$donationCount] :
            null;
    }
}
