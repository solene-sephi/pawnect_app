<?php

namespace App\Entity\Enum;

enum AnimalSexEnum: string
{
    case MALE = 'male';
    case FEMALE = 'female';
    case NOT_APPLICABLE = 'not applicable';
}