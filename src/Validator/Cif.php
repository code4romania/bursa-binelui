<?php

declare(strict_types=1);

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

#[\Attribute]
class Cif extends Constraint
{
    public string $message = '"{{ string }}" is not a valid CUI/CIF';
    public string $mode = 'strict';
}
