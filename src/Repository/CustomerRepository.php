<?php

namespace App\Repository;

use App\Entity\Customer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Customer|null find($id, $lockMode = null, $lockVersion = null)
 * @method Customer|null findOneBy(array $criteria, array $orderBy = null)
 * @method Customer[]    findAll()
 * @method Customer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CustomerRepository extends ServiceEntityRepository
{
    use QueryPaginatorTrait;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Customer::class);
    }


    /**
     * @param $user
     * @param $term
     * @param string $order
     * @param int $maxPerPage
     * @param int $page
     * @return \Pagerfanta\Pagerfanta
     */
    public function searchByUser($user, $term, $order = 'asc', $maxPerPage = 5, $page = 1)
    {
        $qb = $this->createQueryBuilder('c')
            ->select('c, u')
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
        return $this->paginate($qb, $maxPerPage, $page);
    }

}

