<?php

namespace App\Repository;

use App\Entity\Coincoin;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Coincoin>
 *
 * @method Coincoin|null find($id, $lockMode = null, $lockVersion = null)
 * @method Coincoin|null findOneBy(array $criteria, array $orderBy = null)
 * @method Coincoin[]    findAll()
 * @method Coincoin[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CoincoinRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Coincoin::class);
    }

//    /**
//     * @return Coincoin[] Returns an array of Coincoin objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Coincoin
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
