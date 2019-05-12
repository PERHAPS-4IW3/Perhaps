<?php

namespace App\Repository;

use App\Entity\Equipe;
use App\Entity\Projet;
use App\Entity\User;
use App\Entity\ProjetSearch;
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

    public function findProjectByUser(User $user)
    {
        return $this->createQueryBuilder('p')
            ->Where('p.creePar = :user')
            ->setParameter('user', $user)
            ->getQuery()
            ->getResult();
    }

    /**
     * @return array
     */
    public function findProjects(ProjetSearch $search): Query
    {
        $query = $this->findVisibleQuery();

        if($search->getNomProjetSearch()) {
            $query = $query
                ->andwhere('p.nomProjet LIKE :nomProjetSearch')
                ->setParameter('nomProjetSearch', '%'.$search->getNomProjetSearch().'%');
        }

        if($search->getMinBudgetSearch()) {
            $query = $query
                ->andwhere('p.budget >= :minBudgetSearch')
                ->setParameter('minBudgetSearch', $search->getMinBudgetSearch());
        }

        if($search->getTypeProjet()->count() > 0){
            $k = 0;
            foreach ($search->getTypeProjet() as $typeProjet){
                $k++;
                $query = $query
                    ->andWhere(":typeProjets$k MEMBER OF p.typeProjet")
                    ->setParameter("typeProjets$k", $typeProjet);
            }
        }
        return $query->getQuery();
    }

    /**
     * @return array
     */
    public function findLatest(): array
    {
        return $this->findVisibleQuery()
            ->orderBy('p.createdAt', 'DESC')
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

    public function getListOfUserLinkedToPro(Projet $projet)
    {
        $qb = $this->getDoctrine()->createQueryBuilder();
        // $idc = $this->getDoctrine()->createQueryBuilder();

        $qb = $this->getRepository()->createQueryBuilder('user')
            ->select('i AS ilot', 'charge.quantity')
            ->from(User::class, 'user')
            ->where('charge.quantity_at BETWEEN :start AND :end')
            ->orderBy('charge.quantity', 'ASC');

        $qb->setParameter('id_Pro', $projet->getId());

        return $qb->getQuery()->getResult();
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
