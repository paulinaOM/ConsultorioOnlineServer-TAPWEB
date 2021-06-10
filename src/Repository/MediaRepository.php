<?php

namespace App\Repository;

use App\Entity\Media;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Media|null find($id, $lockMode = null, $lockVersion = null)
 * @method Media|null findOneBy(array $criteria, array $orderBy = null)
 * @method Media[]    findAll()
 * @method Media[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MediaRepository extends ServiceEntityRepository
{
    private $manager,$consultationRepository;
    public function __construct(ManagerRegistry $registry, EntityManagerInterface $manager, MedicalConsultationRepository $consultationRepository)
    {
        parent::__construct($registry, Media::class);
        $this->manager=$manager;
        $this->consultationRepository=$consultationRepository;

    }

    public function saveMedia($filename,$id_consultation){
        $newMedia=new Media();
        $consultation=$this->consultationRepository->findOneBy(['id'=>$id_consultation]);

        $newMedia
            ->setFilename($filename)
            ->setIdConsultation($consultation);


        $this->manager->persist($newMedia);
        $this->manager->flush();

    }

    public function findByMedicalConsultation($value)
    {
        return $this->createQueryBuilder('media')
            ->andWhere('media.consultation = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getResult()
            ;
    }


    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }


    public function findOneBySomeField($value): ?Media
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

