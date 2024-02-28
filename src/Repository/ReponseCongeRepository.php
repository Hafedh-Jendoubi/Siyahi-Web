<?php

namespace App\Repository;

use App\Entity\ReponseConge;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ReponseConge>
 *
 * @method ReponseConge|null find($id, $lockMode = null, $lockVersion = null)
 * @method ReponseConge|null findOneBy(array $criteria, array $orderBy = null)
 * @method ReponseConge[]    findAll()
 * @method ReponseConge[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReponseCongeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ReponseConge::class);
    }

//    /**
//     * @return ReponseConge[] Returns an array of ReponseConge objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('r.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?ReponseConge
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
