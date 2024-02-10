<?php

namespace App\Repository;

use App\Entity\CompteClient;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CompteClient>
 *
 * @method CompteClient|null find($id, $lockMode = null, $lockVersion = null)
 * @method CompteClient|null findOneBy(array $criteria, array $orderBy = null)
 * @method CompteClient[]    findAll()
 * @method CompteClient[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CompteClientRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CompteClient::class);
    }

//    /**
//     * @return CompteClient[] Returns an array of CompteClient objects
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

//    public function findOneBySomeField($value): ?CompteClient
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
