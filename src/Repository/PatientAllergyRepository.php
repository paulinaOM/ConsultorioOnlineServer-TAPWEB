<?php

namespace App\Repository;

use App\Entity\Patient;
use App\Entity\PatientAllergy;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PatientAllergy|null find($id, $lockMode = null, $lockVersion = null)
 * @method PatientAllergy|null findOneBy(array $criteria, array $orderBy = null)
 * @method PatientAllergy[]    findAll()
 * @method PatientAllergy[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PatientAllergyRepository extends ServiceEntityRepository
{
    private $manager, $patientRepository, $allergyRepository;
    public function __construct(ManagerRegistry $registry, EntityManagerInterface $manager, PatientRepository $patientRepository, AllergyRepository $allergyRepository)
    {
        parent::__construct($registry, PatientAllergy::class);
        $this->manager = $manager;
        $this->patientRepository = $patientRepository;
        $this->allergyRepository = $allergyRepository;
    }

    public function savePatientAllergy($idPatient,$idAllergy)
    {
        $patient = $this->patientRepository->findOneBy(['id'=>$idPatient]);
        $allergy = $this->allergyRepository->findOneBy(['id'=>$idAllergy]);
        $newPatientAllergy = new PatientAllergy();
        $newPatientAllergy
            ->setIdPatient($patient)
            ->setIdAllergy($allergy);
        $this->manager->persist($newPatientAllergy);
        $this->manager->flush();

    }

    // /**
    //  * @return PatientAllergy[] Returns an array of PatientAllergy objects
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
    public function findManyBySomeField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.patient = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getResult()
        ;
    }
    public function findOneBySomeField($id_patient,$id_allergy): ?PatientAllergy
    {
        return $this->createQueryBuilder('pa')
            ->andWhere('pa.patient = :val')
            ->andWhere('pa.allergy = :val2')
            ->setParameter('val', $id_patient)
            ->setParameter('val2', $id_allergy)
            ->getQuery()
            ->getOneOrNullResult()
            ;
    }
    public function removePatientAllergy(PatientAllergy $patientAllergy){
        $this->manager->remove($patientAllergy);
        $this->manager->flush();
    }


}
