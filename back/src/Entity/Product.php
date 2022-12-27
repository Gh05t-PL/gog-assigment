<?php

namespace App\Entity;

use App\Exception\Product\ProductPriceIsInvalid;
use App\Repository\ProductRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product
{
    #[ORM\Id]
    #[ORM\Column]
    private string $id;

    #[ORM\Column(length: 255, unique: true, nullable: false)]
    private string $title;

    #[ORM\Column(nullable: false)]
    private float $price;

    public function __construct(string $id, string $title, float $price)
    {
        $this->checkPrice($price);

        $this->id = $id;
        $this->title = $title;
        $this->price = $price;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function changePrice(float $price): self
    {
        $this->checkPrice($price);

        $this->price = $price;

        return $this;
    }

    private function checkPrice(float $price): void
    {
        if (2 < strlen(substr(strrchr($price, '.'), 1))) {
            throw new ProductPriceIsInvalid();
        }

        if (0 >= $price) {
            throw new ProductPriceIsInvalid();
        }
    }
}
