<?php

namespace App\Entity\Interface;

use App\Entity\Enum\AnimalStatusEnum;
use App\Entity\Enum\AnimalEventTypeEnum;

interface AnimalEventInterface
{
    public function getEventType(): AnimalEventTypeEnum;

    public function getStatus(): AnimalStatusEnum;
}
