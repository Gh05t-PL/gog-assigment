<?php

namespace App\CQRS\Command\Product\CreateProduct;

class CreateProductCommand implements \App\CQRS\Bus\CommandInterface
{
    private string $id;
    private string $title;
    private float $price;

    public function __construct(
        string $id,
        string $title,
        float $price
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
