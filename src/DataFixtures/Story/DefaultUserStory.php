<?php

namespace App\DataFixtures\Story;

use App\DataFixtures\Factory\ShelterFactory;
use Zenstruck\Foundry\Story;
use App\DataFixtures\Factory\UserFactory;
use App\DataFixtures\Factory\ShelterEmployeeFactory;

final class DefaultUserStory extends Story
{
    public function build(): void
    {
        UserFactory::createOne([
            'email' => 'user@test.fr',
            'password' => 'test1234',
        ]);
    }
}
