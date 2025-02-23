<?php

namespace App\Entity\Enum;

enum AnimalEventTypeEnum: string
{
    case ARRIVAL = 'arrival';
    case ADOPTION = 'adoption';
    case FOSTER_PLACEMENT = 'foster_placement';
    case RETURN = 'return';
    case VACCINATION = 'vaccination';
    case MEDICAL_EVENT = 'medical_event';
}