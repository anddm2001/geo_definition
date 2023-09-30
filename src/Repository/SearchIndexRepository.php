<?php

namespace App\Repository;

use App\Entity\SearchIndex;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SearchIndex|null find($id, $lockMode = null, $lockVersion = null)
 * @method SearchIndex|null findOneBy(array $criteria, array $orderBy = null)
 * @method SearchIndex[]    findAll()
 * @method SearchIndex[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SearchIndexRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SearchIndex::class);
    }


    /**
    * @return SearchIndex[] Returns an array of SearchIndex objects
    */
    public function findByTelField($tel)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.tel = :tel')
            ->setParameter('tel', $tel)
            ->getQuery()
            ->getResult()
        ;
    }

    /*
    public function findOneBySomeField($value): ?SearchIndex
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
