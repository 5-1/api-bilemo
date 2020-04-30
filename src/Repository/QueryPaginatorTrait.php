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

    protected function paginate(QueryBuilder $qb, $limit = 20, $page = 1)
    {
        if (0 == $limit ) {

            throw new \LogicException('$limit & $offstet must be greater than 0.');
        }


        $pager = new Pagerfanta(new DoctrineORMAdapter($qb));


        $pager->setCurrentPage($page);
        $pager->setMaxPerPage($limit);


        return $pager;
    }
}