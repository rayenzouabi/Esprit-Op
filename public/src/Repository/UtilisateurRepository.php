<?php

namespace App\Repository;

use App\Entity\Utilisateur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bridge\Doctrine\Security\User\UserLoaderInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @extends ServiceEntityRepository<Utilisateur>
 *
 * @method Utilisateur|null find($id, $lockMode = null, $lockVersion = null)
 * @method Utilisateur|null findOneBy(array $criteria, array $orderBy = null)
 * @method Utilisateur[]    findAll()
 * @method Utilisateur[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UtilisateurRepository extends ServiceEntityRepository  implements UserLoaderInterface,PasswordUpgraderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Utilisateur::class);
    }
 
    public function save(Utilisateur $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
    public function findByRoleId($roleId)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.role = :roleId')
            ->setParameter('roleId', $roleId)
            ->getQuery()
            ->getResult();
    }
    public function findByemail($email)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.login = :email')
            ->setParameter('email', $email)
            ->getQuery()
            ->getOneOrNullResult();
    }
    public function findBycin($cin)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.cin = :cin')
            ->setParameter('cin', $cin)
            ->getQuery()
            ->getResult();
    }
    public function findByidentifiant($identifiant)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.identifiant = :identifiant')
            ->setParameter('identifiant', $identifiant)
            ->getQuery()
            ->getResult();
    }
    public function remove(Utilisateur $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
    public function loadUserByUsername(string $usernameOrEmail): ?Utilisateur
    {
        return $this->createQueryBuilder('u')
            ->where('u.login = :query')
            ->andWhere('u.role = 2')
            ->andWhere('u.etat = :etat')
            ->setParameter('query', $usernameOrEmail)
            ->setParameter('etat', 'Activé')
            ->getQuery()
            ->getOneOrNullResult();
    }
    public function upgradePassword(UserInterface $user, string $newHashedPassword): void
    {
        // set the new hashed password on the User object
        $user->setPassword($newHashedPassword);

        // execute the queries on the database
        $this->getEntityManager()->flush();
    }
    public function findBySearchTerm($searchTerm)
{
    $qb = $this->createQueryBuilder('u');

    if ($searchTerm) {
        $qb->andWhere('u.nom LIKE :searchTerm OR u.prenom LIKE :searchTerm OR u.cin LIKE :searchTerm OR u.num_identifiant LIKE :searchTerm OR u.ville LIKE :searchTerm OR u.num_tel LIKE :searchTerm OR u.login LIKE :searchTerm OR u.age LIKE :searchTerm ')
            ->andWhere('u.role = 2')
        ->setParameter('searchTerm', '%'.$searchTerm.'%');
    }

    return $qb->getQuery()->getResult();
}

    

//    /**
//     * @return Utilisateur[] Returns an array of Utilisateur objects
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

//    public function findOneBySomeField($value): ?Utilisateur
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
