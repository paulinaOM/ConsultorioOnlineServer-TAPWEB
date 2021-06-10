<?php

namespace App\Repository;

use App\Entity\Prueba1;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Prueba1|null find($id, $lockMode = null, $lockVersion = null)
 * @method Prueba1|null findOneBy(array $criteria, array $orderBy = null)
 * @method Prueba1[]    findAll()
 * @method Prueba1[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class Prueba1Repository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Prueba1::class);
    }

    // /**
    //  * @return Prueba1[] Returns an array of Prueba1 objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Prueba1
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
