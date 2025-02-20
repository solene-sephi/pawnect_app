<?php
namespace App\Entity\Enum;
enum AnimalIdentificationTypeEnum: string
{
    case MICROCHIP = 'microchip';
    case TATOO = 'tattoo';
    case INTERNAL_ID = 'internal_id';
    case OTHER = 'other';
}