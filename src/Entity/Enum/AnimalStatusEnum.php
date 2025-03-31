<?php

namespace App\Entity\Enum;

enum AnimalStatusEnum: string
{
    case IN_SHELTER = 'In shelter';
    case ADOPTED = 'Adopted';
    case IN_FOSTER_CARE = 'In foster care';
}
