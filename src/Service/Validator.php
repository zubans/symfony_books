<?php

namespace App\Service;

use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class Validator
{
    public function validator(): ValidatorInterface
    {
        return Validation::createValidator();
    }
}
