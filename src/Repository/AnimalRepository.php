<?php

namespace App\Repository;

use App\Entity\Animal;
use App\Entity\Enum\AnimalStatusEnum;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Animal>
 */
class AnimalRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Animal::class);
    }

    /**
     * @return Animal[] Returns an array of Animal objects
     */
    public function findAvailableForAdoption(): array
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.deletedAt IS NULL')
            ->andWhere('a.status != :adopted')
            ->orderBy('a.id', 'DESC')
            ->setParameter('adopted', AnimalStatusEnum::ADOPTED)
            ->getQuery()
            ->getResult();
    }
}
