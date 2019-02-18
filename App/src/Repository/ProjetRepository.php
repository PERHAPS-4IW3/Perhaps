<?php

namespace App\Repository;

use App\Entity\Projet;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Projet|null find($id, $lockMode = null, $lockVersion = null)
 * @method Projet|null findOneBy(array $criteria, array $orderBy = null)
 * @method Projet[]    findAll()
 * @method Projet[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProjetRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Projet::class);
    }

    /**
     * @return array
     */
    public function findAllVisible(): array
    {
        return $this->findVisibleQuery()
            ->getQuery()
            ->getResult()
            ;
    }

    /**
     * @return Query
     */

    public function findAllVisibleQuery(): Query
    {
        return $this->findVisibleQuery()
            ->getQuery();
    }


    /**
     * @return array
     */
    public function findProjects(Projet $search): array
    {
        $query = $this->createQueryBuilder('p');

        if($search->getNomProjet() != "") {
            $query = $query
                ->Where('p.nomProjet LIKE :nomProjet')
                ->setParameter('nomProjet', '%'.$search->getNomProjet().'%');
            return $query->getQuery()->getResult();
        }else {
            return $this->findLatest();
        }
    }

    /**
     * @return array
     */
    public function findLatest(): array
    {
        return $this->findVisibleQuery()
            ->orderBy('p.createdAt', 'ASC')
            ->setMaxResults(8)
            ->getQuery()
            ->getResult()
            ;
    }

    private function findVisibleQuery(): QueryBuilder
    {
        return $this->createQueryBuilder('p')
            ->Where('p.isVisible = true');
    }
    // /**
    //  * @return Projet[] Returns an array of Projet objects
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
    public function findOneBySomeField($value): ?Projet
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
