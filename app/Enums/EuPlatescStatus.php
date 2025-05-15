<?php

declare(strict_types=1);

namespace App\Enums;

use App\Concerns\Enums\Arrayable;
use App\Concerns\Enums\Comparable;
use App\Concerns\Enums\HasColor;
use App\Concerns\Enums\HasLabel;

enum EuPlatescStatus: string
{
    use Arrayable;
    use Comparable;
    use HasColor;
    use HasLabel;

    case INITIALIZE = 'initialize';
    case AUTHORIZED = 'authorized';
    case UNAUTHORIZED = 'unauthorized';
    case CANCELED = 'canceled';
    case ABORTED = 'aborted';
    case PAYMENT_DECLINED = 'payment_declined';
    case POSSIBLE_FRAUD = 'possible_fraud';
    case CHARGED = 'charged';
    case CAPTURE = 'capture';

    public function labelKeyPrefix(): string
    {
        return 'donation.statuses';
    }

    public static function colors(): array
    {
        return [
            'initialize' => 'bg-blue-100 text-blue-800',
            'authorized' => 'bg-blue-50 text-blue-800',
            'unauthorized' => 'bg-red-100 text-red-800',
            'canceled' => 'bg-yellow-100 text-yellow-800',
            'aborted' => 'bg-yellow-50 text-yellow-800',
            'payment_declined' => 'bg-red-600 text-red-100',
            'possible_fraud' => 'bg-red-700 text-red-100',
            'charged' => 'bg-green-100 text-green-800',
        ];
    }
}
