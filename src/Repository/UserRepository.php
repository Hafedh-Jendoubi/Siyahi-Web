<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;

/**
 * @extends ServiceEntityRepository<User>
* @implements PasswordUpgraderInterface<User>
 *
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', $user::class));
        }

        $user->setPassword($newHashedPassword);
        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush();
    }

//    /**
//     * @return User[] Returns an array of User objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('u.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

    public function findOneByEmail($value)
    {
        return $this->createQueryBuilder('user')
            ->where('user.email = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getResult();
    }

    public function searchUser($value)
    {
        return $this->createQueryBuilder('u')
            ->where('u.email LIKE :x')
            ->setParameter('x', $value)
            ->getQuery()
            ->getResult();
    }


    /**
     * @throws NonUniqueResultException
     * @throws NoResultException
     */
    public function getClientsOnly(): int
    {
        return $this->createQueryBuilder('u')
            ->select('COUNT(u.id)')
            ->where("JSON_CONTAINS(u.roles, :role)")
            ->setParameter('role', '"ROLE_USER"')
            ->getQuery()
            ->getSingleScalarResult();
    }

    /**
     * @throws NonUniqueResultException
     * @throws NoResultException
     */
    public function getStaffsOnly(): int
    {
        return $this->createQueryBuilder('u')
            ->select('COUNT(u.id)')
            ->where("JSON_CONTAINS(u.roles, :role)")
            ->setParameter('role', '"ROLE_STAFF"')
            ->getQuery()
            ->getSingleScalarResult();
    }

    /**
     * @throws NonUniqueResultException
     * @throws NoResultException
     */
    public function getAdminsOnly(): int
    {
        return $this->createQueryBuilder('u')
            ->select('COUNT(u.id)')
            ->where("JSON_CONTAINS(u.roles, :role)")
            ->setParameter('role', '"ROLE_ADMIN"')
            ->getQuery()
            ->getSingleScalarResult();
    }
}
