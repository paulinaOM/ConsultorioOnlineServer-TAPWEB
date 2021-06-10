<?php

namespace App\Repository;

use App\Entity\ChronicDisease;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ChronicDisease|null find($id, $lockMode = null, $lockVersion = null)
 * @method ChronicDisease|null findOneBy(array $criteria, array $orderBy = null)
 * @method ChronicDisease[]    findAll()
 * @method ChronicDisease[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ChronicDiseaseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ChronicDisease::class);
    }

    // /**
    //  * @return ChronicDisease[] Returns an array of ChronicDisease objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ChronicDisease
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
