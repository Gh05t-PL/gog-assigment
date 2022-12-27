<?php

namespace App\Entity;

use App\Exception\ShoppingCart\ShoppingCartLineExceedsProductQuantityException;
use App\Exception\ShoppingCart\ShoppingCartLineInvalidProductQuantityException;
use App\Repository\ShoppingCartRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ShoppingCartRepository::class)]
class ShoppingCartLine
{
    public const MAX_SAME_PRODUCT_SIZE = 10;

    #[ORM\Id]
    #[ORM\Column]
    private string $id;

    #[ORM\Column]
    private int $quantity;

    #[ORM\ManyToOne]
    private Product $product;

    public function __construct(string $id)
    {
        $this->id = $id;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        if ($quantity > self::MAX_SAME_PRODUCT_SIZE) {
            throw new ShoppingCartLineExceedsProductQuantityException();
        }
        if ($quantity < 1) {
            throw new ShoppingCartLineInvalidProductQuantityException();
        }

        $this->quantity = $quantity;

        return $this;
    }

    public function getProduct(): Product
    {
        return $this->product;
    }

    public function setProduct(Product $product): self
    {
        $this->product = $product;

        return $this;
    }
}
