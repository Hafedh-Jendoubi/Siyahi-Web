<?php

namespace App\Repository;

use App\Entity\ReponseCredit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ReponseCredit>
 *
 * @method ReponseCredit|null find($id, $lockMode = null, $lockVersion = null)
 * @method ReponseCredit|null findOneBy(array $criteria, array $orderBy = null)
 * @method ReponseCredit[]    findAll()
 * @method ReponseCredit[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReponseCreditRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ReponseCredit::class);
    }

//    /**
//     * @return ReponseCredit[] Returns an array of ReponseCredit objects
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

//    public function findOneBySomeField($value): ?ReponseCredit
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
