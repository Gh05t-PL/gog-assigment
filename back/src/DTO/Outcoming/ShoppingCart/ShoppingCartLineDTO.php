<?php

namespace App\DTO\Outcoming\ShoppingCart;

use App\DTO\Outcoming\OutcomingDTO;

class ShoppingCartLineDTO implements OutcomingDTO
{
    private string $lineId;
    private string $productId;
    private string $title;
    private float $unitPrice;
    private int $quantity;

    public function __construct(string $lineId, string $productId, string $title, float $unitPrice, int $quantity)
    {
        $this->lineId = $lineId;
        $this->productId = $productId;
        $this->title = $title;
        $this->unitPrice = $unitPrice;
        $this->quantity = $quantity;
    }

    public function getLineId(): string
    {
        return $this->lineId;
    }

    public function getProductId(): string
    {
        return $this->productId;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getUnitPrice(): float
    {
        return $this->unitPrice;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }
}
