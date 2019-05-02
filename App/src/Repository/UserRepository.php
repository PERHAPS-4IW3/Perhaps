<?php

namespace App\Repository;

use App\Entity\User;
use App\Entity\UserSearch;
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

    /**
     * @param UserSearch $search
     * @return array
     * Fonction qui recherche notre Freelancer
     */
    public function findFreelancers(UserSearch $search): Query
    {
        $query = $this->findVisibleFreelancerQuery();

        if($search->getUserProfession()) {
            $query = $query
                ->andwhere('p.userProfession LIKE :profession')
                ->setParameter('profession', '%'.$search->getUserProfession().'%');
        }

        if($search->getListCompetence()->count() > 0){
            $k = 0;
            foreach ($search->getListCompetence() as $listComp){
                $k++;
                $query = $query
                    ->andWhere(":listCompetences$k MEMBER OF p.listCompetence")
                    ->setParameter("listCompetences$k", $listComp);
            }
        }

        if($search->getUserNameAndCompany()) {
            $query = $query
                ->andwhere('p.userNameAndCompany LIKE :nameAndCompany')
                ->setParameter('nameAndCompany', '%'.$search->getUserNameAndCompany().'%');
        }
        return $query->getQuery();
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
