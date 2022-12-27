<?php

namespace App\CQRS\Query\Product\FetchProductPaginatedList;

use App\CQRS\Bus\QueryInterface;

class FetchProductPaginatedListQuery implements QueryInterface
{
    private int $page;

    public function __construct(int $page)
    {
        $this->page = $page;
    }

    public function getPage(): int
    {
        return $this->page;
    }
}
