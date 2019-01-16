<?php

namespace App\Repository;

use App\Entity\CompetencePosseder;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method CompetencePosseder|null find($id, $lockMode = null, $lockVersion = null)
 * @method CompetencePosseder|null findOneBy(array $criteria, array $orderBy = null)
 * @method CompetencePosseder[]    findAll()
 * @method CompetencePosseder[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CompetencePossederRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, CompetencePosseder::class);
    }

    // /**
    //  * @return CompetencePosseder[] Returns an array of CompetencePosseder objects
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
    public function findOneBySomeField($value): ?CompetencePosseder
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
