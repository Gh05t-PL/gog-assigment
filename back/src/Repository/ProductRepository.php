<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Product>
 *
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    public const MAX_PER_PAGE = 3;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    public function save(Product $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Product $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findPaginated(int $page): array
    {
        $qb = $this->createQueryBuilder('p');

        $qb
            ->orderBy('p.title')
            ->setMaxResults(self::MAX_PER_PAGE)
            ->setFirstResult(($page - 1) * self::MAX_PER_PAGE);

        $items = $qb->getQuery()->getResult();

        $qb = $this->createQueryBuilder('p');

        $qb->select('COUNT(p.id)');

        $total = $qb->getQuery()->getSingleScalarResult();

        return [$items, $total];
    }
}
