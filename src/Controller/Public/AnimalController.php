<?php

namespace App\Controller\Public;

use App\Entity\Animal;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class AnimalController extends AbstractController
{
    #[Route('/animals', name: 'app_animal')]
    public function list(EntityManagerInterface $entityManager): Response
    {
        $animals = $entityManager->getRepository(Animal::class)->findAvailableForAdoption();

        return $this->render('public/animal/list.html.twig', [
            'animals' => $animals,
        ]);
    }
}
