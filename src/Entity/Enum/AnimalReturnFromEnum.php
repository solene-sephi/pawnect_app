<?php

namespace App\Entity\Enum;

enum AnimalReturnFromEnum: string
{
    case ADOPTION = 'adoption';
    case FOSTER_PLACEMENT = 'foster placement';
}