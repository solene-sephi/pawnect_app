<?php

namespace App\Twig\Components\Shelter;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;
use Symfony\Bundle\SecurityBundle\Security;

#[AsTwigComponent]
final class AsideMenu
{
    /**
     * No class properties are used for menu items to avoid shared state.
     * This design ensures that the menu items are not configurable outside the class,
     * promoting encapsulation and reducing the risk of unintended modifications.
     * The public method `getMenuItems` is exposed to retrieve the menu configuration,
     * ensuring that the state is managed internally and consistently.
     */

    public function __construct(
        private Security $security,
    ) {
    }

    public function getMenuItems(): array
    {
        $menuItems = [
            "dashboard" =>
                [
                    "icon" => "ic:round-dashboard",
                    "name" => "Dashboard",
                    "route" => "app_shelter_dashboard"
                ],
            "animals" =>
                [
                    "icon" => "maki:animal-shelter",
                    "name" => "Animals",
                    "route" => "app_shelter_dashboard"
                ],
            "shelter" =>
                [
                    "icon" => "gridicons:house",
                    "name" => "Administration",
                    "route" => "app_shelter_dashboard",
                    "submenus" => [
                        [
                            "name" => "Shelter Info",
                            "route" => "app_shelter_dashboard"
                        ]

                    ]
                ],
        ];

        $this->addAdminMenuItems($menuItems);

        return $menuItems;
    }
    private function addAdminMenuItems(array &$menuItems): void
    {
        if ($this->security->isGranted("ROLE_SHELTER_ADMIN")) {

            $menuItems["shelter"]["submenus"][] =
                [
                    "name" => "Manage Employees",
                    "route" => "app_shelter_dashboard"
                ];
        }
    }
}
