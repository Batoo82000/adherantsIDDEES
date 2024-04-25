<?php

namespace App\Repository;

use AllowDynamicProperties;
use App\Classe\Search;
use App\Entity\Adherants;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Adherants>
 *
 * @method Adherants|null find($id, $lockMode = null, $lockVersion = null)
 * @method Adherants|null findOneBy(array $criteria, array $orderBy = null)
 * @method Adherants[]    findAll()
 * @method Adherants[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
#[AllowDynamicProperties] class AdherantsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Adherants::class);
    }
    public function searchByName(Search $search): array
    {
        $qb = $this->createQueryBuilder('a');

        $qb->where('a.nom LIKE :name')
            ->setParameter('name', '%' . $search->string . '%');
        if(!empty($search->string)) {
            $qb = $qb
                ->andWhere('a.nom LIKE :string')
                ->setParameter('string', "%{$search->string}%");
        }
        // La méthode exécute la requête en appelant getQuery() pour obtenir l'objet Query correspondant à la requête construite, puis getResult() pour obtenir les résultats de la requête sous forme de tableau de produits.
        return $qb->getQuery()->getResult();
    }



    //    /**
    //     * @return Adherants[] Returns an array of Adherants objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('a.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Adherants
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
