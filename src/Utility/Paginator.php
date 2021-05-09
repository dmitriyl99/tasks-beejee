<?php


namespace Utility;


class Paginator
{
    public int $page;

    public string $start;

    public int $total;

    public int $next;

    public int $prev;

    public int $perPage;

    public ?string $queryParams;

    public function __construct(int $page, int $total, int $perPage = 10, string $queryParams = null)
    {
        $start = $perPage * ($page - 1);
        $next = $page+1;
        $prev = $page-1;
        $totalPages = ceil($total / $perPage);

        $this->page = $page;
        $this->start = $start;
        $this->total = $totalPages;
        $this->next = $next;
        $this->prev = $prev;
        $this->perPage = $perPage;
        $this->queryParams = $queryParams;
    }
}