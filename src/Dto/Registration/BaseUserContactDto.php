<?php

declare(strict_types=1);

namespace App\Dto\Registration;

use Symfony\Component\Validator\Constraints as Assert;

class BaseUserContactDto
{
    #[Assert\NotBlank]
    public string $firstName;

    #[Assert\NotBlank]
    public string $lastName;
}
