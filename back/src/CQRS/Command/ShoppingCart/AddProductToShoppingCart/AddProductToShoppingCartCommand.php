<?php

namespace App\CQRS\Command\ShoppingCart\AddProductToShoppingCart;

class AddProductToShoppingCartCommand implements \App\CQRS\Bus\CommandInterface
{
    private string $shoppingCartId;
    private string $productId;
    private int $quantity;

    public function __construct(string $shoppingCartId, string $productId, int $quantity)
    {
        $this->shoppingCartId = $shoppingCartId;
        $this->productId = $productId;
        $this->quantity = $quantity;
    }

    public function getShoppingCartId(): string
    {
        return $this->shoppingCartId;
    }

    public function getProductId(): string
    {
        return $this->productId;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }
}
