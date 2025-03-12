<?php

namespace App\Controller\Shelter;

use App\Service\ShelterService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


#[IsGranted('ROLE_SHELTER_EMPLOYEE')]
final class ShelterDashboardController extends AbstractController
{

    public function __construct(private ShelterService $shelterService)
    {
    }

    #[Route('/dashboard', name: 'app_shelter_dashboard')]
    public function index(): Response
    {
        $user = $this->getUser();
        $shelter = $this->shelterService->getShelterForLoggedUser();

        return $this->render('shelter/index.html.twig', [
            'user' => $user,
            'shelter' => $shelter,
        ]);
    }
}
