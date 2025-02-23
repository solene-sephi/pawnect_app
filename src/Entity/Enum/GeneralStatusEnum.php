<?php

namespace App\Entity\Enum;

enum GeneralStatusEnum: string
{
    case PENDING = 'pending';
    case ACCEPTED = 'accepted';
    case REJECTED = 'rejected';
    case ARCHIVED = 'archived';
}