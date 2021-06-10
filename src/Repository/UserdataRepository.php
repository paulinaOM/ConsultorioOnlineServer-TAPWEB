<?php

namespace App\Repository;

use App\Entity\Userdata;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Userdata|null find($id, $lockMode = null, $lockVersion = null)
 * @method Userdata|null findOneBy(array $criteria, array $orderBy = null)
 * @method Userdata[]    findAll()
 * @method Userdata[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserdataRepository extends ServiceEntityRepository
{
    private $manager;
    public function __construct(ManagerRegistry $registry, EntityManagerInterface $manager)
    {
        parent::__construct($registry, Userdata::class);
        $this->manager=$manager;
    }

    public function saveUser($username,$pwd,$role){
        $newUser=new Userdata();
        $newUser
            ->setUsername($username)
            ->setPwd($pwd)
            ->setRole($role);
        $this->manager->persist($newUser);
        $this->manager->flush();

    }
    // /**
    //  * @return Userdata[] Returns an array of Userdata objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    public function findOneBySomeField($value): ?Userdata
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.username = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    public function login($username,$pwd): ?Userdata
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.username = :val')
            ->andWhere('u.pwd = :val2')
            ->setParameter('val2', $pwd)
            ->setParameter('val', $username)
            ->getQuery()
            ->getOneOrNullResult()
            ;
    }

}
