<?php

namespace App\Repository;

use App\Entity\Telemetry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Telemetry|null find($id, $lockMode = null, $lockVersion = null)
 * @method Telemetry|null findOneBy(array $criteria, array $orderBy = null)
 * @method Telemetry[]    findAll()
 * @method Telemetry[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TelemetryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Telemetry::class);
    }

    // /**
    //  * @return Telemetry[] Returns an array of Telemetry objects
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
    public function findOneBySomeField($value): ?Telemetry
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
