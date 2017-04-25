<?php

// src/Xeng/Cms/CoreBundle/Doctrine/PaginatorUtil.php

namespace Xeng\Cms\CoreBundle\Doctrine;


use Doctrine\ORM\Query;
use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * @author Ermal Mino <ermal.mino@gmail.com>
 * Utility class that works with the native Doctrine pagination
 */
class PaginatorUtil {

    /** @var Query */
    private $query;

    /** @var int */
    private $currentPage;

    /** @var int */
    private $pageSize;

    /**
     * @param Query $query
     * @param int $currentPage
     * @param int $pageSize
     */
    public function __construct(Query $query, $currentPage = 1, $pageSize = 30) {
        $this->currentPage=$currentPage;
        $this->pageSize=$pageSize;
        $this->query = $query;

        $this->query->setFirstResult($pageSize * ($currentPage-1));
        $this->query->setMaxResults($pageSize);
    }

    /**
     *
     * @return PaginatedResult
     */
    public function getPaginatedResult(){
        /** @var Paginator $paginator */
        $paginator = new Paginator($this->query);
        /** @var int $totalItems */
        $totalItems = count($paginator);
        /** @var int $totalPages */
        $totalPages = ceil($totalItems / $this->pageSize);

        /** @var array $results */
        $results = [];

        foreach ($paginator as $item) {
            $results[] = $item;
        }

        return new PaginatedResult($results,$this->currentPage,$this->pageSize,$totalPages);
    }
}