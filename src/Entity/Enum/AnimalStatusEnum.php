<?php

namespace App\Entity\Enum;

enum AnimalStatusEnum: string
{
    case AVAILABLE_FOR_ADOPTION = 'Available for adoption';
    case ADOPTED = 'Adopted';
    case IN_FOSTER_CARE = 'In foster care';
}
