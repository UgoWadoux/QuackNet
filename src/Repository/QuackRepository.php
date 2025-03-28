<?php

namespace App\Repository;

use App\Entity\Quack;
use App\Model\SearchData;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Quack>
 *
 * @method Quack|null find($id, $lockMode = null, $lockVersion = null)
 * @method Quack|null findOneBy(array $criteria, array $orderBy = null)
 * @method Quack[]    findAll()
 * @method Quack[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class QuackRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Quack::class);
    }

    /**
     * Get published post thanks to SerchData
     * @param SearchData $searchData
     * @return array
     */
    public function findBySearch(SearchData $searchData): array
    {
        $data = $this->createQueryBuilder('p');
//            ->where('p.author LIKE :q')
//            ->setParameter('author', '%AUTHOR%');
//        if (!empty($searchData->q)){
            $data= $data
                ->andWhere('p.author LIKE :q')
                ->setParameter('q', "%{$searchData->q}%");
//        }
        $query = $data->getQuery();
        return $query->execute();
    }
//    /**
//     * @return Quack[] Returns an array of Quack objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('q')
//            ->andWhere('q.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('q.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Quack
//    {
//        return $this->createQueryBuilder('q')
//            ->andWhere('q.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
