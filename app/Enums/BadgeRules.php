<?php

declare(strict_types=1);

namespace App\Enums;

use App\Concerns\Enums\Arrayable;
use App\Concerns\Enums\Comparable;
use App\Concerns\Enums\HasLabel;

enum BadgeRules: string
{
    use Arrayable;
    use Comparable;
    use HasLabel;

    case ACTIVITY_REGISTER_AS_USER = 'activity_register_as_user';
    case DONATION_FIRST_COUNTER_DONATION = 'donation_first_counter_donation';
    case DONATION_THREE_COUNTER_DONATION = 'donation_three_counter_donation';
    case DONATION_TEN_COUNTER_DONATION = 'donation_ten_counter_donation';
    case DONATION_FIFTEEN_COUNTER_DONATION = 'donation_fifteen_counter_donation';
    case DONATION_TWENTY_FIVE_COUNTER_DONATION = 'donation_twenty_five_counter_donation';
    case DONATION_FIFTY_COUNTER_DONATION = 'donation_fifty_counter_donation';
    case DONATION_ONE_HUNDRED_AMOUNT_DONATION = 'donation_one_hundred_amount_donation';
    case DONATION_FIVE_HUNDRED_AMOUNT_DONATION = 'donation_five_hundred_amount_donation';
    case DONATION_ONE_THOUSAND_AMOUNT_DONATION = 'donation_one_thousand_amount_donation';
    case DONATION_ONE_THOUSAND_FIVE_HUNDRED_AMOUNT_DONATION = 'donation_one_thousand_five_hundred_amount_donation';
    case DONATION_TWO_THOUSAND_AMOUNT_DONATION = 'donation_two_thousand_amount_donation';

    case DONATION_THREE_TIME_SAME_ORGANIZATION = 'donation_three_time_same_organization';
    case DONATION_TOP_DONOR_ON_PROJECT = 'donation_top_donor_on_project';
    case SHARING_FIRST_SHARE = 'sharing_first_share';
    case SHARING_FIVE_SHARES = 'sharing_five_shares';

    public function labelKeyPrefix(): string
    {
        return 'badge.types';
    }
}
