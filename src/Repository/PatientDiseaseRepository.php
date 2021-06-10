<?php

namespace App\Repository;

use App\Entity\PatientDisease;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PatientDisease|null find($id, $lockMode = null, $lockVersion = null)
 * @method PatientDisease|null findOneBy(array $criteria, array $orderBy = null)
 * @method PatientDisease[]    findAll()
 * @method PatientDisease[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PatientDiseaseRepository extends ServiceEntityRepository
{
    private $manager, $patientRepository, $chronicDiseaseRepository;
    public function __construct(ManagerRegistry $registry, EntityManagerInterface $manager, PatientRepository $patientRepository, ChronicDiseaseRepository $chronicDiseaseRepository)
    {
        parent::__construct($registry, PatientDisease::class);
        $this->manager = $manager;
        $this->patientRepository = $patientRepository;
        $this->chronicDiseaseRepository = $chronicDiseaseRepository;
    }

    public function savePatientDisease($idPatient,$idDisease)
    {
        $patient = $this->patientRepository->findOneBy(['id'=>$idPatient]);
        $chronicDisease = $this->chronicDiseaseRepository->findOneBy(['id'=>$idDisease]);
        $newPatientDisease = new PatientDisease();
        $newPatientDisease
            ->setIdPatient($patient)
            ->setIdDisease($chronicDisease);
        $this->manager->persist($newPatientDisease);
        $this->manager->flush();

    }

    // /**
    //  * @return PatientDisease[] Returns an array of PatientDisease objects
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
    public function findOneBySomeField($value): ?PatientDisease
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    public function findManyBySomeField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.patient = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getResult()
            ;
    }
    public function removePatientDisease(PatientDisease $patientDisease){
        $this->manager->remove($patientDisease);
        $this->manager->flush();
    }

    public function findOneBySomeField($id_patient,$id_disease): ?PatientDisease
    {
        return $this->createQueryBuilder('pa')
            ->andWhere('pa.patient = :val')
            ->andWhere('pa.disease = :val2')
            ->setParameter('val', $id_patient)
            ->setParameter('val2', $id_disease)
            ->getQuery()
            ->getOneOrNullResult()
            ;
    }

}

