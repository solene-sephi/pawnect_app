<?php

namespace App\Controller\Shelter;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;


#[IsGranted('ROLE_SHELTER_EMPLOYEE')]
final class ShelterDashboardController extends AbstractController
{
    #[Route('/shelter/dashboard', name: 'app_shelter_dashboard')]
    public function index(): Response
    {
        /** @var \App\Entity\User $user */
        $user = $this->getUser();
        $shelter = $user->getShelterEmployee()->getShelter()->getName();
        dump($user);
        die;
        return $this->render('shelter/index.html.twig');
    }
}
