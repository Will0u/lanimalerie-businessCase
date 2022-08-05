<?php

namespace App\Repository;

use App\Entity\InsideShoppingCart;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<InsideShoppingCart>
 *
 * @method InsideShoppingCart|null find($id, $lockMode = null, $lockVersion = null)
 * @method InsideShoppingCart|null findOneBy(array $criteria, array $orderBy = null)
 * @method InsideShoppingCart[]    findAll()
 * @method InsideShoppingCart[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InsideShoppingCartRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, InsideShoppingCart::class);
    }

    public function add(InsideShoppingCart $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(InsideShoppingCart $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return InsideShoppingCart[] Returns an array of InsideShoppingCart objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('i.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?InsideShoppingCart
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }


    // ________________________________________________API REQUESTS
    // ____________________________________________________________

    // ____________________________________________________________
    // ____________________________________________________________
    public function getMostPickedProduct(int $length=5 , string $sort='DESC')
    {
        return $this->createQueryBuilder('insideCart')
            ->select(
                    'product.name',
                    'product.id',
                    'SUM(insideCart.quantity) as total'
                )
            ->join('insideCart.product' , 'product')
            ->orderBy('total' , $sort)
            ->groupBy('insideCart.product')
            ->setMaxResults($length)
            ->getQuery()
            ->getResult();
    }


    public function getMostSoldProducts(int $length=5 , string $sort='DESC')
    {
        return $this->createQueryBuilder('insideCart')
            ->select(
                    'product.name',
                    'product.id',
                    'SUM(insideCart.quantity) as total'
                )
            ->join('insideCart.product' , 'product')
            ->join('insideCart.shoppingCart' , 'cart')
            ->join('cart.status' , 'status')
            ->orderBy('total' , $sort)
            ->groupBy('insideCart.product')
            ->where('status.id = 1')
            ->setMaxResults($length)
            ->getQuery()
            ->getResult();
    }

}
