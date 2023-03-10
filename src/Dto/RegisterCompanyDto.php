<?php

declare(strict_types=1);

namespace App\Dto;

use App\Validator as AppAssert;
use Symfony\Component\Validator\Constraints as Assert;

final class RegisterCompanyDto
{
    public const DOMAINS = ['education', 'environment', 'construction', 'pharma'];

    #[Assert\NotBlank]
    public string $name;

    #[Assert\NotBlank]
    #[AppAssert\Cif]
    public string $cui;

    public string $logo;

    public string $description;

    #[Assert\Choice(choices: RegisterCompanyDto::DOMAINS)]
    public string $domains;

    public string $status;

    //TODO: finish adding fields
}
