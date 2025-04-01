<?php

namespace App\Controller\Public;

use App\Entity\Animal;
use Pagerfanta\Pagerfanta;
use Doctrine\ORM\EntityManagerInterface;
use Pagerfanta\Doctrine\ORM\QueryAdapter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class AnimalController extends AbstractController
{
    #[Route('/animals/{page}', name: 'app_animals_list', requirements: ['page' => '\d+'])]
    public function list(EntityManagerInterface $entityManager, Request $request, int $page = 1): Response
    {
        $queryBuilder = $entityManager->getRepository(Animal::class)->AvailableForAdoptionOrderedByNewestQueryBuilder();

        $pagerfanta = new Pagerfanta(
            new QueryAdapter($queryBuilder)
        );

        if ($pagerfanta->getNbPages() < $page) {
            // Redirect to the current routeithout the problamatic parameter, Symfony will use the default $page value (1)
            return $this->redirectToRoute($request->attributes->get('_route'));
        }

        // Careful : The order of the two next lines is important
        $pagerfanta->setMaxPerPage(24);
        $pagerfanta->setCurrentPage($page);

        return $this->render('public/animal/list.html.twig', [
            'pager' => $pagerfanta,
        ]);
    }
}
