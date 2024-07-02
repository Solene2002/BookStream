<?php

namespace App\Repository;

use App\Entity\Alike;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Alike>
 *
 * @method Alike|null find($id, $lockMode = null, $lockVersion = null)
 * @method Alike|null findOneBy(array $criteria, array $orderBy = null)
 * @method Alike[]    findAll()
 * @method Alike[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AlikeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Alike::class);
    }

//    /**
//     * @return Alike[] Returns an array of Alike objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Alike
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
