<?php

namespace App\Repository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;

/**
 * Class AbstractRepository.
 */
trait QueryPaginatorTrait
{
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
}