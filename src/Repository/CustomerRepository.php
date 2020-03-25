<?php

namespace App\Repository;

use App\Entity\Customer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\QueryBuilder;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;

/**
 * @method Customer|null find($id, $lockMode = null, $lockVersion = null)
 * @method Customer|null findOneBy(array $criteria, array $orderBy = null)
 * @method Customer[]    findAll()
 * @method Customer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CustomerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Customer::class);
    }

    public function searchByUser($user, $term, $order = 'asc', $maxPerPage = 5, $offset  = 0)
    {
        $qb = $this->createQueryBuilder('c')
            ->select('c')
            ->innerJoin('c.user', 'u')
            ->where('u = :user')
            ->setParameter('user', $user)
            ->orderBy('c.id', $order);
        if (!empty($term)) {
            $qb->andWhere(
                $qb->expr()->orX(
                    $qb->expr()->like('c.first_name', ':term'),
                    $qb->expr()->like('c.second_name', ':term'),
                    $qb->expr()->like('c.email', ':term')
                )
            )
                ->setParameter('term', '%'.$term.'%');
        }
        return $this->paginate($qb, $maxPerPage, $offset);
    }


    protected function paginate(QueryBuilder $qb, $limit = 20, $offset = 0)
    {
        if (0 == $limit) {
            throw new \LogicException('$limit & $offstet must be greater than 0.');
        }

        $pager = new Pagerfanta(new DoctrineORMAdapter($qb));

        $currentPage = ceil(($offset + 1)/ $limit);
        $pager->setCurrentPage($currentPage);
        $pager->setMaxPerPage((int) $limit);

        return $pager;
    }

    // /**
    //  * @return Customer[] Returns an array of Customer objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Customer
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
