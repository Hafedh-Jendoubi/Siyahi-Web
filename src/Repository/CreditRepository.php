<?php

namespace App\Repository;

use App\Entity\Credit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Credit>
 *
 * @method Credit|null find($id, $lockMode = null, $lockVersion = null)
 * @method Credit|null findOneBy(array $criteria, array $orderBy = null)
 * @method Credit[]    findAll()
 * @method Credit[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CreditRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Credit::class);
    }

//    /**
//     * @return Credit[] Returns an array of Credit objects
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

//    public function findOneBySomeField($value): ?Credit
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }

public function findSortedByMontant()
    {
        return $this->createQueryBuilder('s')
        ->orderBy('s.solde_demande','DESC')
            ->getQuery()->getResult();
    }

public function findSortedByDate()
    {
        return $this->createQueryBuilder('s')
        ->orderBy('s.date_debut_paiement','DESC')
            ->getQuery()->getResult();
    }

    public function getCreditStatistics(): array
    {
        $queryBuilder = $this->createQueryBuilder('c')
            ->select('c.date_debut_paiement AS date, COUNT(c.id) AS count')
            ->groupBy('c.date_debut_paiement')
            ->getQuery();

        return $queryBuilder->getResult();
    }
    public function findAllCredits(): array
    {
        $qb = $this->createQueryBuilder('c')
            ->getQuery();

        return $qb->getResult();
    }
    
    public function findCreditsByYear(int $year): array
    {
        $qb = $this->createQueryBuilder('c')
            ->andWhere('YEAR(c.date_debut_paiement) = :year')
            ->setParameter('year', $year)
            ->getQuery();

        return $qb->getResult();
    }


    public function findByPriceRange($minSolde, $maxSolde)
{
    return $this->createQueryBuilder('p')
        ->where('p.solde_demande >= :minSolde')
        ->andWhere('p.solde_demande <= :maxSolde')
        ->setParameter('minSolde', $minSolde)
        ->setParameter('maxSolde', $maxSolde)
        ->getQuery()
        ->getResult();
}
}
