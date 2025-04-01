<?php

namespace App\Entity\Enum;

enum AnimalSexEnum: string
{
    case MALE = 'male';
    case FEMALE = 'female';
    case NOT_APPLICABLE = 'not applicable';

    public function getLabel(bool $isFront = false): string
    {
        return match ($this) {
            self::NOT_APPLICABLE => $isFront ? '-' : ucfirst($this->value),
            default => ucfirst($this->value),
        };
    }
}