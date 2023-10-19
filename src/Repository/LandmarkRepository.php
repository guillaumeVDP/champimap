<?php

namespace App\Repository;

use App\Entity\Landmark;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Landmark>
 *
 * @method Landmark|null find($id, $lockMode = null, $lockVersion = null)
 * @method Landmark|null findOneBy(array $criteria, array $orderBy = null)
 * @method Landmark[]    findAll()
 * @method Landmark[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LandmarkRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Landmark::class);
    }

//    /**
//     * @return Landmark[] Returns an array of Landmark objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('l')
//            ->andWhere('l.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('l.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Landmark
//    {
//        return $this->createQueryBuilder('l')
//            ->andWhere('l.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
