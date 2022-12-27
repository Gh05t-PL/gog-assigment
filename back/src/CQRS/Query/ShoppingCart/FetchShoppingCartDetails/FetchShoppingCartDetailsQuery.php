<?php

namespace App\CQRS\Query\ShoppingCart\FetchShoppingCartDetails;

use App\CQRS\Bus\QueryInterface;

class FetchShoppingCartDetailsQuery implements QueryInterface
{
    private string $id;

    public function __construct(string $id)
    {
        $this->id = $id;
    }

    public function getId(): string
    {
        return $this->id;
    }
}
