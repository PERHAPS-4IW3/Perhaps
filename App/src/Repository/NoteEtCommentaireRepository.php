<?php

namespace App\Repository;

use App\Entity\NoteEtCommentaire;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method NoteEtCommentaire|null find($id, $lockMode = null, $lockVersion = null)
 * @method NoteEtCommentaire|null findOneBy(array $criteria, array $orderBy = null)
 * @method NoteEtCommentaire[]    findAll()
 * @method NoteEtCommentaire[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NoteEtCommentaireRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, NoteEtCommentaire::class);
    }

    // /**
    //  * @return NoteEtCommentaire[] Returns an array of NoteEtCommentaire objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('n.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?NoteEtCommentaire
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
