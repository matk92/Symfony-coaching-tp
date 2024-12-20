<?php

namespace App\Repository;

use App\Entity\Coach;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Coach>
 */
class CoachRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Coach::class);
    }

    /**
     * @return Coach[] Returns an array of Coach objects
     */
    public function findBySearchAndFilter(?string $search, ?string $filter): array
    {
        $qb = $this->createQueryBuilder('c');

        if ($search) {
            $qb->andWhere('c.firstName LIKE :search OR c.lastName LIKE :search')
               ->setParameter('search', '%' . $search . '%');
        }

        if ($filter) {
            // Ajoutez des conditions de filtre ici si nécessaire
        }

        return $qb->getQuery()->getResult();
    }
}
