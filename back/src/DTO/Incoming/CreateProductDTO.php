<?php

namespace App\DTO\Incoming;

use App\Entity\Product;
use App\Validator\UniqueField;
use Symfony\Component\Validator\Constraints as Assert;

class CreateProductDTO
{
    #[Assert\NotBlank()]
    #[Assert\Type(type: 'string')]
    #[Assert\Length(min: 1, max: 256)]
    #[UniqueField(entityFqcn: Product::class, entityProperty: 'title')]
    private mixed $title;

    #[Assert\NotBlank()]
    #[Assert\Type(type: 'numeric')]
    private mixed $price;

    public function __construct(
        mixed $title,
        mixed $price,
    ) {
        $this->title = $title;
        $this->price = $price;
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
