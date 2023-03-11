<?php

declare(strict_types=1);

namespace App\Dto\Registration\Company;

use Symfony\Component\Validator\Constraints as Assert;

final class CompanyContactDto
{
    #[Assert\NotBlank]
    public string $county;

    #[Assert\NotBlank]
    public string $city;

    #[Assert\NotBlank]
    public string $address;

    #[Assert\NotBlank]
    public string $firstName;

    #[Assert\NotBlank]
    public string $lastName;

    #[Assert\NotBlank]
    public string $phone;

    #[Assert\NotBlank]
    #[Assert\Email]
    public string $email;

    #[Assert\Url]
    public string $website;
}
