<?php

declare(strict_types=1);

namespace App\Enums;

use App\Concerns\Enums\Arrayable;
use App\Concerns\Enums\HasLabel;

enum EuPlatescStatus: string
{
    use Arrayable;
    use HasLabel;
    case INITIALIZE = 'initialize';
    case AUTHORIZED = 'authorized';
    case UNAUTHORIZED = 'unauthorized';
    case CANCELED = 'canceled';
    case ABORTED = 'aborted';
    case PAYMENT_DECLINED = 'payment_declined';
    case POSSIBLE_FRAUD = 'possible_fraud';
    case CHARGED = 'charged';

    public function labelKeyPrefix(): string
    {
        return 'donation.statuses';
    }
}
