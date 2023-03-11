<?php

declare(strict_types=1);

namespace App\Dto\Registration\Donor;

use App\Dto\Registration\BaseUserContactDto;

final class UserContactDto extends BaseUserContactDto
{
    public bool $newsletter;
}
