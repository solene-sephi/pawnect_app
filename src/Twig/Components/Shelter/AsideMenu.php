<?php

namespace App\Twig\Components\Shelter;

use App\Security\Voter\ShelterVoter;
use App\Service\ShelterService;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

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
        private ShelterService $shelterService,
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
        $shelter = $this->shelterService->getShelterForLoggedUser();

        if ($this->security->isGranted(ShelterVoter::EDIT_PARTIALLY, $shelter)) {
            $menuItems["shelter"]["submenus"][] =
                [
                    "name" => "Manage Employees",
                    "route" => "app_shelter_dashboard"
                ];
        }
    }
}
