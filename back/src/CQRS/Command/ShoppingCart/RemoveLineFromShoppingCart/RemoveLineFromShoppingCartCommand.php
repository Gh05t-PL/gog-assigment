<?php

namespace App\CQRS\Command\ShoppingCart\RemoveLineFromShoppingCart;

class RemoveLineFromShoppingCartCommand implements \App\CQRS\Bus\CommandInterface
{
    private string $id;

    public function __construct(
        string $id,
    ) {
        $this->id = $id;
    }

    public function getId(): string
    {
        return $this->id;
    }
}
