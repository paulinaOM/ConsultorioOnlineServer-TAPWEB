<?php

namespace App\Repository;

use App\Entity\DoctorService;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method DoctorService|null find($id, $lockMode = null, $lockVersion = null)
 * @method DoctorService|null findOneBy(array $criteria, array $orderBy = null)
 * @method DoctorService[]    findAll()
 * @method DoctorService[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DoctorServiceRepository extends ServiceEntityRepository
{
    private $manager,$doctorRepository,$serviceRepository;
    public function __construct(ManagerRegistry $registry, EntityManagerInterface $manager, DoctorRepository $doctorRepository,ServiceRepository $serviceRepository)
    {
        parent::__construct($registry, DoctorService::class);
        $this->manager=$manager;
        $this->doctorRepository=$doctorRepository;
        $this->serviceRepository=$serviceRepository;
    }

    public function saveDoctorService($id_doctor,$id_service,$cost){
        $newDoctorService=new DoctorService();
        $doctor=$this->doctorRepository->findOneBy(['id'=>$id_doctor]);
        $service=$this->serviceRepository->findOneBy(['id'=>$id_service]);
        $newDoctorService
            ->setIdDoctor($doctor)
            ->setIdService($service)
            ->setCost($cost);

        $this->manager->persist($newDoctorService);
        $this->manager->flush();

    }

    public function updateDoctorService(DoctorService $doctorService): DoctorService
    {
        $this->manager->persist($doctorService);
        $this->manager->flush();

        return $doctorService;
    }

    public function removeDoctorService(DoctorService $doctorService){
        $this->manager->remove($doctorService);
        $this->manager->flush();
    }

    // /**
    //  * @return DoctorService[] Returns an array of DoctorService objects
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


    public function findOneBySomeField($id_service,$id_doctor): ?DoctorService
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.service = :val')
            ->andWhere('d.doctor = :val2')
            ->setParameter('val', $id_service)
            ->setParameter('val2', $id_doctor)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

}
