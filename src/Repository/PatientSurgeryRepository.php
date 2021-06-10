<?php

namespace App\Repository;

use App\Entity\PatientSurgery;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PatientSurgery|null find($id, $lockMode = null, $lockVersion = null)
 * @method PatientSurgery|null findOneBy(array $criteria, array $orderBy = null)
 * @method PatientSurgery[]    findAll()
 * @method PatientSurgery[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PatientSurgeryRepository extends ServiceEntityRepository
{
    private $manager, $patientRepository, $surgeryRepository;
    public function __construct(ManagerRegistry $registry, EntityManagerInterface $manager, PatientRepository $patientRepository, SurgeryRepository $surgeryRepository)
    {
        parent::__construct($registry, PatientSurgery::class);
        $this->manager = $manager;
        $this->patientRepository = $patientRepository;
        $this->surgeryRepository = $surgeryRepository;
    }

    public function savePatientSurgery($idPatient,$idSurgery)
    {
        $patient = $this->patientRepository->findOneBy(['id'=>$idPatient]);
        $surgery = $this->surgeryRepository->findOneBy(['id'=>$idSurgery]);
        $newPatientSurgery = new PatientSurgery();
        $newPatientSurgery
            ->setIdPatient($patient)
            ->setIdSurgery($surgery);
        $this->manager->persist($newPatientSurgery);
        $this->manager->flush();
    }
    public function findManyBySomeField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.patient = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getResult()
            ;
    }

    // /**
    //  * @return PatientSurgery[] Returns an array of PatientSurgery objects
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
    public function findOneBySomeField($value): ?PatientSurgery
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    public function findOneBySomeField($id_patient,$id_surgery): ?PatientSurgery
    {
        return $this->createQueryBuilder('pa')
            ->andWhere('pa.patient = :val')
            ->andWhere('pa.surgery = :val2')
            ->setParameter('val', $id_patient)
            ->setParameter('val2', $id_surgery)
            ->getQuery()
            ->getOneOrNullResult()
            ;
    }
    public function removePatientSurgery(PatientSurgery $patientSurgery){
        $this->manager->remove($patientSurgery);
        $this->manager->flush();
    }

}
