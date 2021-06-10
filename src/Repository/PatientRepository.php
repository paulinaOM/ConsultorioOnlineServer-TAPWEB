<?php

namespace App\Repository;

use App\Entity\Patient;
use App\Entity\Userdata;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use PhpParser\Node\Expr\Cast\Object_;

/**
 * @method Patient|null find($id, $lockMode = null, $lockVersion = null)
 * @method Patient|null findOneBy(array $criteria, array $orderBy = null)
 * @method Patient[]    findAll()
 * @method Patient[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PatientRepository extends ServiceEntityRepository
{
    private $manager,$userdataRepository;
    public function __construct(ManagerRegistry $registry, EntityManagerInterface $manager, UserdataRepository $userdataRepository)
    {
        parent::__construct($registry, Patient::class);
        $this->manager=$manager;
        $this->userdataRepository=$userdataRepository;
    }

    public function savePatient($name,$lastname,$address,$city,$state,$country,$birthdate
        ,$phone,$email,$id_user,$latitud,$longitud,$status_covid){
        $newPatient=new Patient();
        $user=$this->userdataRepository->findOneBy(['id'=>$id_user]);
        $newPatient
            ->setName($name)
            ->setLastname($lastname)
            ->setAddress($address)
            ->setCity($city)
            ->setState($state)
            ->setCountry($country)
            ->setBirthdate(\DateTime::createFromFormat('Y-m-d', $birthdate))
            ->setPhone($phone)
            ->setEmail($email)
            ->setIdUser($user)
            ->setLatitud((float)$latitud)
            ->setLongitud((float)$longitud)
            ->setStatusCovid($status_covid);


        $this->manager->persist($newPatient);
        $this->manager->flush();

    }

    // /**
    //  * @return Patient[] Returns an array of Patient objects
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
    public function findOneBySomeField($value): ?Patient
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    public function getPatient($id):Patient{
       return $this->createQueryBuilder('p')
            ->andWhere('p.user = :val')
            ->setParameter('val', $id)
            ->getQuery()
            ->getOneOrNullResult()
            ;
    }
    public function updateStatus(Patient $patient): Patient
    {
        $this->manager->persist($patient);
        $this->manager->flush();

        return $patient;
    }
    public function countCovid($state, $city, $status)
    {
        $qb = $this->manager->createQueryBuilder();
        $qb->select('count(patient.id) as total');
        $qb->from('App\Entity\Patient', 'patient')
            ->andWhere('patient.status_covid = :status')
            ->andWhere('patient.state = :state')
            ->andWhere('patient.city = :city')
            ->setParameter('status', $status)
            ->setParameter('state', $state)
            ->setParameter('city', $city);

        $count = $qb->getQuery()->getSingleScalarResult();
        return $count;
    }
    public function findByState($state, $country)
    {
        $cities= $this->manager->createQueryBuilder()
            ->select('patient.city')
            ->from('App\Entity\Patient', 'patient')
            ->andWhere('patient.state = :state')
            ->andWhere('patient.country = :country')
            ->setParameter('state', $state)
            ->setParameter('country', $country)
            ->distinct(true)
            ->getQuery()
            ->getResult()
        ;

        return $cities;
    }


}
