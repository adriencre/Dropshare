<?php

namespace App\Repository;

use App\Entity\Contact;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Contact>
 * 
 * @method Contact|null find($id, $lockMode = null, $lockVersion = null)
 * @method Contact|null findOneBy(array $criteria, array $orderBy = null)
 * @method Contact[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * @method Contact[]    findAll()
 */
class ContactRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Contact::class);
    }

    /**
     * Récupère tous les contacts présents dans la base de données.
     * 
     * @return Contact[] Returns an array of Contact objects
     */
    public function findAllContacts(): array
    {
        return $this->findAll();
    }

    /**
     * Récupère un contact par son identifiant.
     * 
     * @param int $id
     * @return Contact|null
     */
    public function findContactById(int $id): ?Contact
    {
        return $this->find($id);
    }

    /**
     * Récupère un contact par un critère.
     * 
     * @param array $criteria
     * @return Contact|null
     */
    public function findOneContactBy(array $criteria): ?Contact
    {
        return $this->findOneBy($criteria);
    }

    /**
     * Récupère plusieurs contacts en fonction de critères donnés.
     * 
     * @param array $criteria
     * @param array|null $orderBy
     * @param int|null $limit
     * @param int|null $offset
     * @return Contact[]
     */
    public function findContactsBy(array $criteria, ?array $orderBy = null, ?int $limit = null, ?int $offset = null): array
    {
        return $this->findBy($criteria, $orderBy, $limit, $offset);
    }
}
