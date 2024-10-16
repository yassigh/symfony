<?php

namespace App\Repository;

use App\Entity\Article;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Article::class);
    }

    /**
     * Trouve les articles dans une plage de prix spécifiée
     *
     * @param int|null $minValue Valeur minimale du prix
     * @param int|null $maxValue Valeur maximale du prix
     * @return Article[] Liste des articles correspondant aux critères
     */
    public function findByPriceRange($minValue, $maxValue)
    {
        // Construction de la requête avec QueryBuilder
        return $this->createQueryBuilder('a')
            ->andWhere('a.prix >= :minVal')
            ->setParameter('minVal', $minValue)
            ->andWhere('a.prix <= :maxVal')
            ->setParameter('maxVal', $maxValue)
            ->orderBy('a.id', 'ASC')  // Optionnel: Tri par ID
            ->setMaxResults(10)  // Limite les résultats à 10
            ->getQuery()
            ->getResult();
    }
}
