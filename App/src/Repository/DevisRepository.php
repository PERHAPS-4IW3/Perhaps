<?php

namespace App\Repository;

use App\Entity\Devis;
use App\Entity\Projet;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Devis|null find($id, $lockMode = null, $lockVersion = null)
 * @method Devis|null findOneBy(array $criteria, array $orderBy = null)
 * @method Devis[]    findAll()
 * @method Devis[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DevisRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Devis::class);
    }

    public function getNbOffre(User $user)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.etabliPar = :user')
            ->setParameter('user', $user)
            ->select('COUNT(p.id)')
            ->getQuery() ->getSingleScalarResult();

    }



    /**
     * @return Devis[] Returns an array of Devis objects
     */

    /*public function projetFree($id)
    {
        return $this->createQueryBuilder('d')
            ->innerJoin('p.id', 'p')
            ->Where('d.projetid = :id')
            ->setParameter('id', $id)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }*/


    /*
    public function findOneBySomeField($value): ?Devis
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
