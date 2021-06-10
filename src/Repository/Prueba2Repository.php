<?php

namespace App\Repository;

use App\Entity\Prueba1;
use App\Entity\Prueba2;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Prueba2|null find($id, $lockMode = null, $lockVersion = null)
 * @method Prueba2|null findOneBy(array $criteria, array $orderBy = null)
 * @method Prueba2[]    findAll()
 * @method Prueba2[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class Prueba2Repository extends ServiceEntityRepository
{
    private $manager,$prueba1rep;
    public function __construct(ManagerRegistry $registry, EntityManagerInterface $manager,Prueba1Repository $prueba1rep)
    {
        parent::__construct($registry, Prueba2::class);
        $this->manager=$manager;
        $this->prueba1rep=$prueba1rep;

    }

    public function savePrueba2($foraneo_id,$campo1){
        $newPrueba2=new Prueba2();

        $prueba1=new Prueba1();
        $prueba1=$this->prueba1rep->findOneBy(['id'=>$foraneo_id]);
        $newPrueba2
            ->setForaneo($prueba1)
            ->setCampo1($campo1);

        $this->manager->persist($newPrueba2);
        $this->manager->flush();

    }

    // /**
    //  * @return Prueba2[] Returns an array of Prueba2 objects
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
    public function findOneBySomeField($value): ?Prueba2
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
