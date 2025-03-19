<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

#[\Attribute]
class PhoneNumber extends Constraint
{
    public string $message = 'Please enter a valid phone number. It can include numbers, spaces, dashes, periods, slashes, parentheses, and an optional leading plus sign.';
}