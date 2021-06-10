<?php

namespace App\Repository;

use App\Entity\TaxData;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TaxData|null find($id, $lockMode = null, $lockVersion = null)
 * @method TaxData|null findOneBy(array $criteria, array $orderBy = null)
 * @method TaxData[]    findAll()
 * @method TaxData[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TaxDataRepository extends ServiceEntityRepository
{
    private $manager, $patientRepository, $paymentRepository;

    public function __construct(ManagerRegistry $registry, EntityManagerInterface $manager, PatientRepository $patientRepository, PaymentRepository $paymentRepository)
    {
        parent::__construct($registry, TaxData::class);
        $this->manager = $manager;
        $this->patientRepository = $patientRepository;
        $this -> paymentRepository = $paymentRepository;
    }

    public function saveTaxdata($idPatient,$billingAddress,$shippingDate,$idPayment)
    {
        $patient = $this->patientRepository->findOneBy(['id'=>$idPatient]);
        $payment = $this->paymentRepository->findOneBy(['id'=>$idPayment]);
        $newTaxdata = new TaxData();
        $newTaxdata
            ->setIdPatient($patient)
            ->setBillingAddress($billingAddress)
            ->setShippingDate($shippingDate)
            ->setIdPayment($payment);
        $this->manager->persist($newTaxdata);
        $this->manager->flush();

    }
    public function updateTaxData(TaxData $taxData): TaxData
    {
        $this->manager->persist($taxData);
        $this->manager->flush();

        return $taxData;
    }

    // /**
    //  * @return TaxData[] Returns an array of TaxData objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */


    public function findOneBySomeField($value): ?TaxData
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.patient = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

}

