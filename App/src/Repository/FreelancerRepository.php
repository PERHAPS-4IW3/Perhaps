<?php

namespace App\Repository;

use App\Entity\Freelancer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Freelancer|null find($id, $lockMode = null, $lockVersion = null)
 * @method Freelancer|null findOneBy(array $criteria, array $orderBy = null)
 * @method Freelancer[]    findAll()
 * @method Freelancer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */

class FreelancerRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Freelancer::class);
    }

    /**
     * @return array
     */
    /*public function findAllVisible(): array
    {
        return $this->findVisibleQuery()
            ->getQuery()
            ->getResult()
            ;
    }*/

    /**
     * @return array
     */
    /*public function findLatest(): array
    {
        return $this->findVisibleQuery()
            //->orderBy('p.createdAt', 'ASC')
            ->setMaxResults(8)
            ->getQuery()
            ->getResult()
            ;
    }

    */
    /*private function findVisibleQuery(): QueryBuilder
    {
        return $this->createQueryBuilder('p')
            ->Where('p.isVisible = true');
    }*/


    // /**
    //  * @return Freelancer[] Returns an array of Freelancer objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Freelancer
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
