<?php

namespace App\Repository;

use App\Entity\Prescription;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Prescription|null find($id, $lockMode = null, $lockVersion = null)
 * @method Prescription|null findOneBy(array $criteria, array $orderBy = null)
 * @method Prescription[]    findAll()
 * @method Prescription[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PrescriptionRepository extends ServiceEntityRepository
{
    private $manager, $medicalConsultationRepository;
    public function __construct(ManagerRegistry $registry, EntityManagerInterface $manager, MedicalConsultationRepository $medicalConsultationRepository)
    {
        parent::__construct($registry, Prescription::class);
        $this->manager= $manager;
        $this->medicalConsultationRepository= $medicalConsultationRepository;

    }

    public function savePrescription($idMedicalConsultation,$filename)
    {
        $medicalConsultation = $this->medicalConsultationRepository->findOneBy(['id'=>$idMedicalConsultation]);
        $newPrescription = new Prescription();
        $newPrescription
            ->setIdConsultation($medicalConsultation)
            ->setFilename($filename);
        $this->manager->persist($newPrescription);
        $this->manager->flush();

    }
    /**
     * @param $id
     * @return Prescription[]
     */
    public function getPrescriptionsByPatient($id)
    {
        $query = $this->createQueryBuilder('pr')
            ->innerJoin('App\Entity\MedicalConsultation', 'mc', 'WITH',"mc.id=pr.medicalConsultation")
            ->andWhere('mc.patient = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getResult();

        return $query;
    }
    /**
     * @param $id
     * @return Prescription[]
     */
    public function getPrescriptionsByDoctor($id)
    {
        $query = $this->createQueryBuilder('pr')
            ->innerJoin('App\Entity\MedicalConsultation', 'mc', 'WITH',"mc.id=pr.medicalConsultation")
            ->andWhere('mc.doctor = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getResult();

        return $query;
    }


    // /**
    //  * @return Prescription[] Returns an array of Prescription objects
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
    public function findOneBySomeField($value): ?Prescription
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



