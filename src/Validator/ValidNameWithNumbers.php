<?php
namespace App\Validator;

use Symfony\Component\Validator\Constraint;

#[\Attribute]
class ValidNameWithNumbers extends Constraint
{
    public string $message = "This field can only contain letters, numbers, spaces, apostrophes, accents, and hyphens.";
}