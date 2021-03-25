<?php

namespace App\Repository;

use App\Entity\Symfony;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Symfony|null find($id, $lockMode = null, $lockVersion = null)
 * @method Symfony|null findOneBy(array $criteria, array $orderBy = null)
 * @method Symfony[]    findAll()
 * @method Symfony[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SymfonyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Symfony::class);
    }

    // /**
    //  * @return Symfony[] Returns an array of Symfony objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Symfony
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
