<?php

namespace App\DTO\Outcoming\Product;

use App\DTO\Outcoming\OutcomingDTO;

class SingleProductDTO implements OutcomingDTO
{
    private string $id;
    private string $title;
    private float $price;

    public function __construct(
        string $id,
        string $title,
        float $price,
    ) {
        $this->id = $id;
        $this->title = $title;
        $this->price = $price;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getPrice(): float
    {
        return $this->price;
    }
}
