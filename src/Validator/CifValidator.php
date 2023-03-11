<?php

declare(strict_types=1);

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class CifValidator extends ConstraintValidator
{

    private static array $controlKey = [7, 5, 3, 2, 1, 7, 5, 3, 2];

    public function validate(mixed $value, Constraint $constraint)
    {
        if (!$constraint instanceof Cif) {
            throw new UnexpectedTypeException($constraint, Cif::class);
        }

        if (!$this->cuiValidation($value)) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ string }}', $value)
                ->addViolation();
        }
    }

    private function cuiValidation($cif): bool
    {
        if (!is_numeric($cif)) {
            return false;
        }
        if ((int)$cif <= 0) {
            return false;
        }
        $cifLength = strlen($cif);
        if ($cifLength > 10) {
            return false;
        }
        if ($cifLength < 2) {
            return false;
        }

        $controlKey = (int)substr($cif, -1);
        $cif = substr($cif, 0, -1);
        $cif = str_pad($cif, 9, '0', STR_PAD_LEFT);
        $suma = 0;
        foreach (self::$controlKey as $i => $key) {
            $suma += $cif[$i] * $key;
        }
        $suma = $suma * 10;
        $rest = (int)($suma % 11);
        $rest = ($rest == 10) ? 0 : $rest;

        if ($rest === $controlKey) {
            return true;
        }

        return false;
    }
}
