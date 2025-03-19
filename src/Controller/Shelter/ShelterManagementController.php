<?php

namespace App\Controller\Shelter;

use App\Service\ShelterService;
use App\Form\Shelter\ShelterType;
use App\Security\Voter\ShelterVoter;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/shelter')]
final class ShelterManagementController extends AbstractController
{
    public function __construct(private ShelterService $shelterService)
    {
    }

    #[Route('/edit', name: 'app_shelter_management_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, EntityManagerInterface $entityManager): Response
    {
        $shelter = $this->shelterService->getShelterForLoggedUser();

        $this->denyAccessUnlessGranted(ShelterVoter::EDIT_PARTIALLY, $shelter);

        $form = $this->createForm(
            ShelterType::class,
            $shelter,
            ['disabled_fields' => ['street', 'city', 'state', 'country', 'zipCode']]
        );

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_shelter_management_edit');
        }

        return $this->render('shelter/shelter_management/edit.html.twig', [
            'shelter' => $shelter,
            'form' => $form,
        ]);
    }
}
