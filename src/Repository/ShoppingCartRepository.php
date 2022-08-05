<?php

namespace App\Repository;

use App\Entity\ShoppingCart;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ShoppingCart>
 *
 * @method ShoppingCart|null find($id, $lockMode = null, $lockVersion = null)
 * @method ShoppingCart|null findOneBy(array $criteria, array $orderBy = null)
 * @method ShoppingCart[]    findAll()
 * @method ShoppingCart[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ShoppingCartRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ShoppingCart::class);
    }

    public function add(ShoppingCart $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ShoppingCart $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return ShoppingCart[] Returns an array of ShoppingCart objects
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

//    public function findOneBySomeField($value): ?ShoppingCart
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }


    // ________________________________________________API REQUESTS
    // ____________________________________________________________

    // carts collection____________________________________________
    // ____________________________________________________________
    public function getAllCarts()
    {
        return $this->createQueryBuilder('stats')
            ->select(
                    'count(stats) as totalCarts'
                )
            ->join('stats.status' , 'status')
            ->getQuery()
            ->getResult();
    }

    public function getValidatesCart()
    {
        return $this->createQueryBuilder('stats')
            ->select(
                    'count(stats) as totalValidatedCarts'
                )
            ->join('stats.status' , 'status')
            ->where('status.id = 1')
            ->getQuery()
            ->getResult();
    }

    public function getFailedCarts()
    {
        return $this->createQueryBuilder('stats')
            ->select(
                    'count(stats) as totalFailedCarts'
                )
            ->join('stats.status' , 'status')
            ->where('status.id = 2')
            ->getQuery()
            ->getResult();
    }

    public function getStandByValidationCarts()
    {
        return $this->createQueryBuilder('stats')
            ->select(
                    'count(stats) as totalValidationStandByCarts'
                )
            ->join('stats.status' , 'status')
            ->where('status.id = 3')
            ->getQuery()
            ->getResult();
    }

    public function getAbortedCarts()
    {
        return $this->createQueryBuilder('stats')
            ->select(
                    'count(stats) as totalAbortedCarts'
                )
            ->join('stats.status' , 'status')
            ->where('status.id = 4')
            ->getQuery()
            ->getResult();
    }

    public function getStandByPaymentCarts()
    {
        return $this->createQueryBuilder('stats')
            ->select(
                    'count(stats) as totalPaymentStandByCarts'
                )
            ->join('stats.status' , 'status')
            ->where('status.id = 5')
            ->getQuery()
            ->getResult();
    }

    public function getAverageMoney()
    {
        return $this->createQueryBuilder('cart')
            ->select(
                    'AVG(product.priceHt * insideShoppingCarts.quantity) as averageMoney'
                )
            ->join('cart.insideShoppingCarts' , 'insideShoppingCarts')
            ->join('insideShoppingCarts.product' , 'product')
            ->getQuery()
            ->getResult();
    }
}
