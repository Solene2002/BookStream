<?php

namespace App\Repository;

use App\Entity\Livre;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\ORM\Query\ResultSetMappingBuilder;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Livre>
 *
 * @method Livre|null find($id, $lockMode = null, $lockVersion = null)
 * @method Livre|null findOneBy(array $criteria, array $orderBy = null)
 * @method Livre[]    findAll()
 * @method Livre[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LivreRepository extends ServiceEntityRepository
{
    public const PAGINATOR_PER_PAGE=3;
    
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Livre::class);
    }
    
    //    /**
    //     * @return Livre[] Returns an array of Livre objects
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
    
    //    public function findOneBySomeField($value): ?Livre
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
    
        /**
         * @return Livre[] Returns an array of Livre objects
         */
        public function findLivreLastComment($value): array
        {      
            $entityManager = $this->getEntityManager();
            $rsm = new ResultSetMappingBuilder($entityManager);
            $rsm->addRootEntityFromClassMetadata('App\Entity\Livre', 'livre');  
            $sql="  SELECT livre.*
                    FROM livre
                    INNER JOIN comment
                    ON (livre.id = comment.livre_id)
                    WHERE SUBSTRING(comment.created_at,1,10)= :val
                    AND livre.etat_id = 3
                    ORDER BY livre.id DESC
                ";
            $query = $entityManager->createNativeQuery($sql,$rsm);
            $query->setParameter('val', $value);
            return $query->getResult();      
        }
    
        // /**
        //  * @return Livre[] Returns an array of Livre objects
        //  */  
        public function getLivrePaginator(int $offset):Paginator
        {
            $query= $this->createQueryBuilder('a')
                ->andWhere('a.etat = 4')
                ->orderBy('a.createdAt', 'DESC')
                ->setMaxResults(self::PAGINATOR_PER_PAGE)
                ->setFirstResult($offset)
                ->getQuery()
            ;
    
            return new Paginator($query);
        }
    
    
    
    
    }