<?php

declare(strict_types=1);

namespace App\Dto\Registration\Company;

use App\Enums\Industry;
use App\Validator as AppAssert;
use Symfony\Component\Validator\Constraints as Assert;

final class InfoDto
{

    #[Assert\NotBlank]
    public string $name;

    #[Assert\NotBlank]
    #[AppAssert\Cif]
    public string $cui;

    public string $logo;

    public string $description;

    /**
     * @var Industry[]
     */
    public array $domains;

    public string $status;

    //TODO: finish adding fields
}
