<?php

namespace App\Repository;

use App\Entity\MedicalConsultation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method MedicalConsultation|null find($id, $lockMode = null, $lockVersion = null)
 * @method MedicalConsultation|null findOneBy(array $criteria, array $orderBy = null)
 * @method MedicalConsultation[]    findAll()
 * @method MedicalConsultation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MedicalConsultationRepository extends ServiceEntityRepository
{
    private $manager, $patientRepository, $doctorRepository;

    public function __construct(ManagerRegistry $registry,EntityManagerInterface $manager, PatientRepository $patientRepository, DoctorRepository $doctorRepository)
    {
        parent::__construct($registry, MedicalConsultation::class);
        $this->manager = $manager;
        $this->patientRepository = $patientRepository;
        $this -> doctorRepository = $doctorRepository;
    }

    public function saveMedicalConsultation($idPatient,$symptom,$atentionStatus,$consultationDate,$idDoctor)
    {
        $patient = $this->patientRepository->findOneBy(['id'=>$idPatient]);
        $doctor = $this->doctorRepository->findOneBy(['id'=>$idDoctor]);
        $newMedicalConsultation = new MedicalConsultation();
        $newMedicalConsultation
            ->setSymptom($symptom)
            ->setAtentionStatus($atentionStatus)
            ->setConsultationDate(\DateTime::createFromFormat('Y-m-d',$consultationDate))
            ->setIdPatient($patient)
            ->setIdDoctor($doctor);
        $this->manager->persist($newMedicalConsultation);
        $this->manager->flush();
    }
    /**
     * @return integer[]
     */
    public function findLast()
    {
        $query = $this->manager->createQuery(
            'SELECT mc.id
       FROM App\Entity\MedicalConsultation mc
       ORDER BY mc.id DESC'
        )->setMaxResults(1);

        // returns an array
        $idToArray = $query->getResult();
        return $idToArray[0];
    }

    public function findManyBySomeField($value)
    {
        return $this->createQueryBuilder('mc')
            ->innerJoin('App\Entity\Doctor','d','WITH','mc.doctor=d.id')
            ->andWhere('d.speciality = :val')
            ->andWhere('mc.atention_status = 1')
            ->setParameter('val', $value)
            ->getQuery()
            ->getResult()
            ;
    }

    public function updateConsultation(MedicalConsultation $medicalConsultation): MedicalConsultation
    {
        $this->manager->persist($medicalConsultation);
        $this->manager->flush();

        return $medicalConsultation;
    }
    public function updateStatus(MedicalConsultation $medicalConsultation): MedicalConsultation
    {
        $this->manager->persist($medicalConsultation);
        $this->manager->flush();

        return $medicalConsultation;
    }


    // /**
    //  * @return MedicalConsultation[] Returns an array of MedicalConsultation objects
    //  */
    /*
    public function findByExampleField($value)
    {PatientSurgery
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?MedicalConsultation
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
