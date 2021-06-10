<?php

namespace App\Repository;

use App\Entity\Doctor;
use App\Entity\Patient;
use App\Entity\Userdata;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Doctor|null find($id, $lockMode = null, $lockVersion = null)
 * @method Doctor|null findOneBy(array $criteria, array $orderBy = null)
 * @method Doctor[]    findAll()
 * @method Doctor[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DoctorRepository extends ServiceEntityRepository
{
    private $manager,$userdataRepository,$specialityRepository;
    public function __construct(ManagerRegistry $registry, EntityManagerInterface $manager, SpecialityRepository $specialityRepository,UserdataRepository $userdataRepository)
    {
        parent::__construct($registry, Doctor::class);
        $this->manager=$manager;
        $this->userdataRepository=$userdataRepository;
        $this->specialityRepository=$specialityRepository;
    }

    public function saveDoctor($name,$lastname,$address,$city,$state,$country,$license
        ,$mobile_phone,$email,$id_user,$id_speciality){
        $newDoctor=new Doctor();
        $user=$this->userdataRepository->findOneBy(['id'=>$id_user]);
        $speciality=$this->specialityRepository->findOneBy(['id'=>$id_speciality]);
        $newDoctor
            ->setName($name)
            ->setLastname($lastname)
            ->setAddress($address)
            ->setCity($city)
            ->setState($state)
            ->setCountry($country)
            ->setLicense($license)
            ->setMobilePhone($mobile_phone)
            ->setEmail($email)
            ->setIdUser($user)
            ->setIdSpeciality($speciality);


        $this->manager->persist($newDoctor);
        $this->manager->flush();

    }
    public function getDoctor($id):Doctor
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.user = :val')
            ->setParameter('val', $id)
            ->getQuery()
            ->getOneOrNullResult();

    }
    // /**
    //  * @return Doctor[] Returns an array of Doctor objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Doctor
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
