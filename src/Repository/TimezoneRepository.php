<?php

namespace App\Repository;

use App\Entity\Timezone;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Timezone|null find($id, $lockMode = null, $lockVersion = null)
 * @method Timezone|null findOneBy(array $criteria, array $orderBy = null)
 * @method Timezone[]    findAll()
 * @method Timezone[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TimezoneRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Timezone::class);
    }

    public function getTimezone($country_id, $region_id = ""){

        if(!empty($region_id)){
            $timezones = $this->getDoctrine()->getRepository(Timezone::class);
            $data = $timezones->findOneBy(["region_id" => $region_id]);
            $timezone = $data->getTimezone();
            return $timezone;
        }elseif(!empty($country_id)){
            $timezones = $this->getDoctrine()->getRepository(Timezone::class);
            $data = $timezones->findOneBy(["country_id" => $country_id]);
            $timezone = $data->getTimezone();
            return $timezone;
        }
        return ["error" => $this->error[5]];
    }

    // /**
    //  * @return Timezone[] Returns an array of Timezone objects
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
    public function findOneBySomeField($value): ?Timezone
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
