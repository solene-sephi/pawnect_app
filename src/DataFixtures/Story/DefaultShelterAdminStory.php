<?php

namespace App\DataFixtures\Story;

use Zenstruck\Foundry\Story;
use App\DataFixtures\Factory\UserFactory;
use App\DataFixtures\Factory\ShelterFactory;
use App\DataFixtures\Factory\ShelterEmployeeFactory;

final class DefaultShelterAdminStory extends Story
{
    public function build(): void
    {
        $user = UserFactory::createOne([
            'email' => 'admin@shelter.fr',
            'password' => 'test1234',
            'roles' => ['ROLE_SHELTER_ADMIN'],
        ]);

        ShelterEmployeeFactory::createOne([
            'employeeUser' => $user,
            'shelter' => ShelterFactory::randomOrCreate()
        ]);
    }
}