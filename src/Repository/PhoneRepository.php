<?php


namespace App\Repository;
use App\Entity\Phone;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\QueryBuilder;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;

/**
 * Class PhoneRepository.
 */
class PhoneRepository  extends ServiceEntityRepository
{
   use QueryPaginatorTrait;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Phone::class);
    }


    /**
     * @param $term
     * @param string $order
     * @param int    $maxPerPage
     * @param int    $page
     *
     * @return \Pagerfanta\Pagerfanta
     */
    public function search($term, $order = 'asc', $maxPerPage = 5, $page  =1)
    {
        $qb = $this->createQueryBuilder('p')
            ->select('p')
            ->innerJoin('p.brand', 'b')
            ->orderBy('p.id', $order);
        if (!empty($term)) {
            $qb->andWhere(
                $qb->expr()->orX(
                    $qb->expr()->like('p.name', ':term'),
                    $qb->expr()->like('b.name', ':term')
                )
            )
                ->setParameter('term', '%'.$term.'%');
        }
        return $this->paginate($qb, $maxPerPage, $page);
    }
}
