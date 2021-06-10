<?php

namespace App\Repository;

use App\Entity\ConsultationService;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ConsultationService|null find($id, $lockMode = null, $lockVersion = null)
 * @method ConsultationService|null findOneBy(array $criteria, array $orderBy = null)
 * @method ConsultationService[]    findAll()
 * @method ConsultationService[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ConsultationServiceRepository extends ServiceEntityRepository
{
    private $manager,$medicalConsultationRepository,$doctorServiceRepository;
    public function __construct(ManagerRegistry $registry, EntityManagerInterface $manager, MedicalConsultationRepository $medicalConsultation,DoctorServiceRepository $doctorServiceRepository)
    {
        parent::__construct($registry, ConsultationService::class);
        $this->manager=$manager;
        $this->medicalConsultationRepository=$medicalConsultation;
        $this->doctorServiceRepository=$doctorServiceRepository;
    }

    public function saveConsultationService($id_consultation,$id_service){
        $newCS=new ConsultationService();
        $consultation=$this->medicalConsultationRepository->findOneBy(['id'=>$id_consultation]);
        $service=$this->doctorServiceRepository->findOneBy(['id'=>$id_service]);
        $newCS
            ->setIdConsultation($consultation)
            ->setIdService($service);

        $this->manager->persist($newCS);
        $this->manager->flush();

    }

    // /**
    //  * @return ConsultationService[] Returns an array of ConsultationService objects
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
    public function findOneBySomeField($value): ?ConsultationService
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
