<?php

namespace App\Repository;

use App\Entity\Bill;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Bill|null find($id, $lockMode = null, $lockVersion = null)
 * @method Bill|null findOneBy(array $criteria, array $orderBy = null)
 * @method Bill[]    findAll()
 * @method Bill[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BillRepository extends ServiceEntityRepository
{
    private $manager, $medicalConsultationRepository;
    public function __construct(ManagerRegistry $registry, EntityManagerInterface $manager, MedicalConsultationRepository $medicalConsultationRepository)
    {
        parent::__construct($registry, Bill::class);
        $this->manager = $manager;
        $this->medicalConsultationRepository = $medicalConsultationRepository;
    }

    public function saveBill($idMedicalConsultation,$filename)
    {
        $medicalConsultation = $this->medicalConsultationRepository->findOneBy(['id'=>$idMedicalConsultation]);
        $newBill = new Bill();
        $newBill
            ->setIdConsultation($medicalConsultation)
            ->setFilename($filename);
        $this->manager->persist($newBill);
        $this->manager->flush();
    }
    /**
     * @param $id
     * @return Bill[]
     */
    public function getBillsByPatient($id)
    {
        $query = $this->createQueryBuilder('b')
            ->innerJoin('App\Entity\MedicalConsultation', 'mc', 'WITH',"mc.id=b.medicalConsultation")
            ->innerJoin('App\Entity\Patient', 'p','WITH',"p.id=mc.patient")
            ->andWhere('p.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getResult();

        return $query;

//        $em->createQueryBuilder()
//            ->select('r')
//            ->from('CRMCoreBundle:User', 'u')
//            ->innerJoin('u.profiles','p')
//            ->where('u.id = :user_id')
//            ->setParameter('user_id', $user->getId())
//            ->getQuery()
//            ->getResult();

    }
    public function getBillsByDoctor($id)
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
    //  * @return Bill[] Returns an array of Bill objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Bill
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
