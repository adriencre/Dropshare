<?php
// src/Repository/CategorieRepository.php

namespace App\Repository;

use App\Entity\Categorie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Categorie>
 */
class CategorieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Categorie::class);
    }

    /**
     * Récupère toutes les catégories triées par ordre alphabétique.
     *
     * @return Categorie[] Returns an array of Categorie objects
     */
    public function findAllSortedByLibelle(): array
    {
        return $this->createQueryBuilder('c')
            ->orderBy('c.libelle', 'ASC')
            ->getQuery()
            ->getResult();
    }
}
