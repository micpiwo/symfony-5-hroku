<?php

namespace App\Repository;

use App\Entity\Produits;
use App\Entity\Recherche;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Produits|null find($id, $lockMode = null, $lockVersion = null)
 * @method Produits|null findOneBy(array $criteria, array $orderBy = null)
 * @method Produits[]    findAll()
 * @method Produits[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProduitsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Produits::class);
    }

    // /**
    //  * @return Produits[] Returns an array of Produits objects
    //  */

    public function searchParameters($prix, $cat)
    {
        $query =  $this->createQueryBuilder('r')
            ->orderBy('r.id', 'ASC')
        ;
        if($prix){
            $query = $query
                ->andWhere('r.prixProduit < :prixMax')
                ->setParameter('prixMax', $prix);

        }

        if($cat){
            $query = $query
                ->andWhere('r.categorie_id = :catgorieID')
                ->setParameter('catgorieID', $cat);

        }
        return $query->getQuery()->getResult();
    }


    /*
    public function findOneBySomeField($value): ?Produits
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
