<?php

namespace App\Repository;

use App\Entity\Produit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Produit|null find($id, $lockMode = null, $lockVersion = null)
 * @method Produit|null findOneBy(array $criteria, array $orderBy = null)
 * @method Produit[]    findAll()
 * @method Produit[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProduitRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Produit::class);
    }

    // Exemple utilisant le QueryBuider
    public function findByPriceInterval($pmin,$pmax)
    {
        $qb = $this->createQueryBuilder('p')
        ->andWhere('p.price > :min')
        ->setParameter('min', $pmin)
        ->andWhere('p.price < :max')
        ->setParameter('max', $pmax);

        $query= $qb->getQuery();
        $resultat = $query->getResult();
        return $resultat;


        /*
        return $this->createQueryBuilder('p')
        ->andWhere('p.price > :min')
        ->setParameter('min', $min)
        ->andWhere('p.price < :max')
        ->setParameter('max', $max)
      //  ->orderBy('p.id', 'ASC')
      //  ->setMaxResults(10)
        ->getQuery()
        ->getResult()
    ;*/
    }
    
    // Exemple utilisant le langage DQL
    public  function findByPriceInterval2($pmin,$pmax)
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT p
            FROM App\Entity\Produit p
            WHERE p.price > :min and p.price < :max
            ORDER BY p.price ASC'
        )->setParameter('min', $pmin)
         ->setParameter('max', $pmax);

        // returns an array of Product objects
        return $query->getResult();
    }

    // /**
    //  * @return Produit[] Returns an array of Produit objects
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
    public function findOneBySomeField($value): ?Produit
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
