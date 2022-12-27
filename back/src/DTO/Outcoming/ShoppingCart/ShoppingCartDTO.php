<?php

namespace App\DTO\Outcoming\ShoppingCart;

use App\DTO\Outcoming\OutcomingDTO;

class ShoppingCartDTO implements OutcomingDTO
{
    private string $id;
    private array $items;
    private float $totalPrice;

    public function __construct(string $id, array $items, float $totalPrice)
    {
        $this->id = $id;
        $this->items = $items;
        $this->totalPrice = $totalPrice;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getItems(): array
    {
        return $this->items;
    }

    public function getTotalPrice(): float
    {
        return $this->totalPrice;
    }
}
