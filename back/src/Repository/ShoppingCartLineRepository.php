<?php

namespace App\Repository;

use App\Entity\ShoppingCartLine;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ShoppingCartLine>
 *
 * @method ShoppingCartLine|null find($id, $lockMode = null, $lockVersion = null)
 * @method ShoppingCartLine|null findOneBy(array $criteria, array $orderBy = null)
 * @method ShoppingCartLine[]    findAll()
 * @method ShoppingCartLine[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ShoppingCartLineRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ShoppingCartLine::class);
    }

    public function save(ShoppingCartLine $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ShoppingCartLine $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
