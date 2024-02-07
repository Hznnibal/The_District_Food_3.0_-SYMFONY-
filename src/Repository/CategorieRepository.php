<?php

namespace App\Repository;

use App\Entity\Categorie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Categorie>
 *
 * @method Categorie|null find($id, $lockMode = null, $lockVersion = null)
 * @method Categorie|null findOneBy(array $criteria, array $orderBy = null)
 * @method Categorie[]    findAll()
 * @method Categorie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategorieRepository extends ServiceEntityRepository
{
//     public function __construct(ManagerRegistry $registry)
//     {
//         parent::__construct($registry, Categorie::class);
//     }

//     public function getSomeCategories($name)
// {
//     //$name est un paramètre qui pour cet exemple a come valeur "Neil";
//     $entityManager = $this->getEntityManager(); //on instancie l'entity manager

//     $query = $entityManager->createQuery( //on crée la requête 
//         'SELECT c
//         FROM App\Entity\Categorie c
//         WHERE c.libelle  like :name'
//     )->setParameter('libelle', '%'.$name.'%');

//     // retourne un tableau d'objets de type Artist
//     return $query->getResult();

// }
public function __construct(ManagerRegistry $registry)
{
    parent::__construct($registry, Categorie::class);
}

public function findMenuItems()
{
    return $this->createQueryBuilder('p')
        ->leftJoin('p.categorie', 'c')
        ->select('p.libelle AS plat_libelle', 'p.description', 'p.prix', 'p.image', 'c.id AS plat_categorie')
        ->setMaxResults(6)
        ->getQuery()
        ->getResult();
}
}

//    /**
//     * @return Categorie[] Returns an array of Categorie objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Categorie
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }

