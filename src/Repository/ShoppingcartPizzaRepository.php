<?php

namespace App\Repository;

use App\Entity\ShoppingcartPizza;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ShoppingcartPizza>
 *
 * @method ShoppingcartPizza|null find($id, $lockMode = null, $lockVersion = null)
 * @method ShoppingcartPizza|null findOneBy(array $criteria, array $orderBy = null)
 * @method ShoppingcartPizza[]    findAll()
 * @method ShoppingcartPizza[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ShoppingcartPizzaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ShoppingcartPizza::class);
    }

    public function save(ShoppingcartPizza $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ShoppingcartPizza $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return ShoppingcartPizza[] Returns an array of ShoppingcartPizza objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?ShoppingcartPizza
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
