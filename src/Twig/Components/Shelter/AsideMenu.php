<?php

namespace App\Twig\Components\Shelter;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
final class AsideMenu
{
    public function getMenuItems(): array
    {
        $menuItems = [
            ["icon" => "ic:round-dashboard", "name" => "Dashboard", "route" => "app_shelter_dashboard"],
            ["icon" => "maki:animal-shelter", "name" => "Animals", "route" => "app_shelter_dashboard"],
            ["icon" => "gridicons:house", "name" => "Shelter", "route" => "app_shelter_dashboard"],
        ];

        return $menuItems;
    }
}
