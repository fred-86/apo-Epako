<?php

namespace App\Repository;

use App\Entity\PlaceCategory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PlaceCategory|null find($id, $lockMode = null, $lockVersion = null)
 * @method PlaceCategory|null findOneBy(array $criteria, array $orderBy = null)
 * @method PlaceCategory[]    findAll()
 * @method PlaceCategory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PlaceCategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PlaceCategory::class);
    }

    // /**
    //  * @return PlaceCategory[] Returns an array of PlaceCategory objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?PlaceCategory
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    //Todo a faire non fonctionnel
    public function findAllPlaceByProductCategoryAndPostalcode($value)
    {
        return $this->createQueryBuilder('p')
            ->innerJoin('places.productCategories','pc')
            ->andWhere('pc.id = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getResult()
        ;
    }
}

