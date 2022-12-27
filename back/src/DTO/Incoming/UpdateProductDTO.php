<?php

namespace App\DTO\Incoming;

use Symfony\Component\Validator\Constraints as Assert;

class UpdateProductDTO
{
    #[Assert\NotBlank()]
    #[Assert\Type(type: 'string')]
    #[Assert\Length(min: 1, max: 256)]
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
