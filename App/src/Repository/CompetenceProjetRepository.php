<?php

namespace App\Repository;

use App\Entity\CompetenceProjet;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method CompetenceProjet|null find($id, $lockMode = null, $lockVersion = null)
 * @method CompetenceProjet|null findOneBy(array $criteria, array $orderBy = null)
 * @method CompetenceProjet[]    findAll()
 * @method CompetenceProjet[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CompetenceProjetRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, CompetenceProjet::class);
    }

    // /**
    //  * @return CompetenceProjet[] Returns an array of CompetenceProjet objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CompetenceProjet
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
