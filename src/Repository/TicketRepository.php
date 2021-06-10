<?php

namespace App\Repository;

use App\Entity\Ticket;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Ticket|null find($id, $lockMode = null, $lockVersion = null)
 * @method Ticket|null findOneBy(array $criteria, array $orderBy = null)
 * @method Ticket[]    findAll()
 * @method Ticket[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TicketRepository extends ServiceEntityRepository
{
    private $manager, $patientRepository;
    public function __construct(ManagerRegistry $registry, EntityManagerInterface $manager, PatientRepository $patientRepository)
    {
        parent::__construct($registry, Ticket::class);
        $this->manager= $manager;
        $this->patientRepository= $patientRepository;
    }
    /**
     * @param $id
     * @return Ticket[]
     */
    public function getTicketsByPatient($id)
    {
        $query = $this->createQueryBuilder('t')
            ->innerJoin('App\Entity\Patient', 'p','WITH',"p.id=t.idPatient")
            ->andWhere('p.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getResult();

        return $query;
    }
    public function saveTicket($idPatient,$dateSale,$filename)
    {
        $patient = $this->patientRepository->findOneBy(['id'=>$idPatient]);
        $newTicket = new Ticket();
        $newTicket
            ->setIdPatient($patient)
            ->setFilename($filename)
            ->setDateSale(\DateTime::createFromFormat('Y-m-d',$dateSale));
        $this->manager->persist($newTicket);
        $this->manager->flush();
    }

    public function findLast(): ?Ticket
    {
        return $this->createQueryBuilder('t')
            ->orderBy('t.id', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }

    // /**
    //  * @return Ticket[] Returns an array of Ticket objects
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

    /*
    public function findOneBySomeField($value): ?Ticket
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
