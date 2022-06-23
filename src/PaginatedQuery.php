<?php

namespace App;

use Exception;
use PDO;

class PaginatedQuery {

    private $query;
    private $queryCount;
    private $classMapping;
    private $pdo;
    private $perPage;

    public function __construct(
        string $query,
        string $queryCount,
        string $classMapping,
        ?PDO $pdo = null,
        int $perPage = 12
    )
    {
        $this->query = $query;
        $this->queryCount = $queryCount;
        $this->classMapping = $classMapping;
        $this->pdo = $pdo ?: Connection::getPDO();
        $this->perPage = $perPage;
    }

    public function getItems (): array
    {
        $currentPage = $this->getCurrentPage();
        $pages = $this->getPages();
        if ($currentPage > $pages){
            throw new Exception("Cette page n'existe pas");
        };      
        $offset = $this->perPage * ($currentPage - 1);
        return $this->pdo->query(
            $this->query .
            " LIMIT {$this->perPage} OFFSET $offset")
            ->fetchAll(PDO::FETCH_CLASS, $this->classMapping);
    }

    public function previousLink (string $link): ?string
    {
        $currentPage = $this->getCurrentPage();
        echo $currentPage;
        if ($currentPage <= 1) return null;
        if ($currentPage > 2) $link .= "?page=" . ($currentPage -1);
        
        return <<<HTML
        <a href="{$link}" class="btn btn-primary">&laquo; Page précédente</a>
HTML;
    }

    public function nextLink (string $link): ?string
    {
        $currentPage = $this->getCurrentPage();
        echo $currentPage;
        if ($currentPage <= 1) return null;
        if ($currentPage > 2) $link .= "?page=" . ($currentPage -1);
        
        return <<<HTML
        <a href="{$link}" class="btn btn-primary">&laquo; Page précédente</a>
HTML;
    }

    private function getCurrentPage (): int
    {
        return URL::getPositiveInt('page', 1);
    }

    private function getPages (): int
    {
        
    }
}