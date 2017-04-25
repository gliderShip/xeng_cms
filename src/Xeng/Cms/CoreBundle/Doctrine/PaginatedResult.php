<?php

// src/Xeng/Cms/CoreBundle/Doctrine/PaginatedResult.php

namespace Xeng\Cms\CoreBundle\Doctrine;

/**
 * @author Ermal Mino <ermal.mino@gmail.com>
 * This class serves as a convenience result wrapper for paginated results
 */
class PaginatedResult {

    /** @var int */
    private $currentPage;

    /** @var int */
    private $pageSize;

    /** @var int */
    private $totalPages;

    /** @var array */
    private $results;

    /**
     * @param array $results
     * @param int $currentPage
     * @param int $pageSize
     * @param int $totalPages
     */
    public function __construct($results, $currentPage, $pageSize, $totalPages) {
        $this->results = $results;
        $this->currentPage = $currentPage;
        $this->pageSize = $pageSize;
        $this->totalPages = $totalPages;
    }

    /**
     * @return int
     */
    public function getCurrentPage(){
        return $this->currentPage;
    }

    /**
     * @return int
     */
    public function getPageSize(){
        return $this->pageSize;
    }

    /**
     * @return int
     */
    public function getTotalPages(){
        return $this->totalPages;
    }

    /**
     * @return array
     */
    public function getResults(){
        return $this->results;
    }

}