<?php

namespace App\Repository;

use App\Entity\Session;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Session>
 */
class SessionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Session::class);
    }

    /**
     * @return Session[] Returns an array of Session objects
     */
    public function findBySearchAndFilter(?string $search, ?string $filter): array
    {
        $qb = $this->createQueryBuilder('s')
            ->join('s.program', 'p')
            ->join('p.coach', 'c');

        if ($search) {
            $qb->andWhere('p.name LIKE :search OR c.firstName LIKE :search OR c.lastName LIKE :search')
               ->setParameter('search', '%' . $search . '%');
        }

        if ($filter) {
            if ($filter === 'coach') {
                $qb->andWhere('c.firstName LIKE :search OR c.lastName LIKE :search')
                   ->setParameter('search', '%' . $search . '%');
            } elseif ($filter === 'program') {
                $qb->andWhere('p.name LIKE :search')
                   ->setParameter('search', '%' . $search . '%');
            }
        }

        return $qb->getQuery()->getResult();
    }
}
