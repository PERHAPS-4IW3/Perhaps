<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Query;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Bridge\Doctrine\Security\User\UserLoaderInterface;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository implements UserLoaderInterface
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * @param string $email
     * @return mixed|null|\Symfony\Component\Security\Core\User\UserInterface
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function loadUserByUsername($email)
    {
        return $this->createQueryBuilder('u')
            ->where('u.email = :email')
            ->setParameter('email', $email)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * Fonction qui liste tous les freelancers actifs
     */
    public function findVisibleFreelancerQuery(): QueryBuilder
    {
        return $this->findVisibleQuery()
            ->andWhere('f.roles LIKE :role')
            ->setParameter('role', '%"ROLE_FREELANCER"%')
            ;
    }

    /*private function findVisibleFreelancerQuery(): QueryBuilder
    {
        return $this->createQueryBuilder('p')
            ->Where("p.roles LIKE :role")
            ->setParameter('role', '%"ROLE_FREELANCER"%');
    }*/

    /**
     * @param User $search
     * @return array
     * Fonction qui recherche notre Freelancer
     */
    public function findFreelancers(User $search): array
    {
        $query = $this->findVisibleFreelancerQuery();

        if($search->getNomUser() != "" || $search->getPrenomUser() != "") {
            $query = $query
                ->andWhere('f.nomUser LIKE :nomUser')
                ->andWhere('f.prenomUser LIKE :prenomUser')
                ->setParameter('nomUser', '%'.$search->getNomUser().'%')
                ->setParameter('prenomUser', '%'.$search->getPrenomUser().'%');
            return $query->getQuery()->getResult();
        }else {
            return $query->getQuery()->getResult();
        }
    }

    public function findLikeName(){
        return $this
            ->createQueryBuilder('p')
            ->where('f.nomUser LIKE :nomUser')
            ->setParameter('nomUser', '%$nomUser%')
            ->getQuery()
            ->execute();
    }

    /**
     * @return array
     * Fonction qui liste tous les Porteurs de Projets actifs
     */
    public function findVisiblePorteurProjetQuery(): array
    {
        return $this->findVisibleQuery()
            ->andWhere('f.roles LIKE :role')
            ->setParameter('role', '%"ROLE_USER"%')
            ->getQuery()
            ->getResult();
    }

    /**
     * @return array
     * Fonction qui liste tous les Freelancers
     */
    public function findVisibleAllFreelancerQuery(): array
    {
        return $this->findVisibleFreelancerQuery()
            ->getQuery()
            ->getResult();
    }

    /**
     * @return array
     * Fonction qui liste tous les utilisateurs (freelancer et porteur de projet) actif
     */
    public function findAllVisibleUserQuery(): array
    {
        return $this->findVisibleQuery()
            ->getQuery()
            ->getResult();
    }

    public function findAllFreelancers(): Query{
        return $this->findVisibleFreelancerQuery()
            ->getQuery();
    }


    private function findVisibleQuery(): QueryBuilder
    {
        return $this->createQueryBuilder('f')
            ->Where('f.isActive = true');
    }

    // /**
    //  * @return User[] Returns an array of User objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?User
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
