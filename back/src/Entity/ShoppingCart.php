<?php

namespace App\Entity;

use App\Exception\ShoppingCart\ShoppingCartExceedsSizeException;
use App\Repository\ShoppingCartRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ShoppingCartRepository::class)]
class ShoppingCart
{
    public const MAX_DIFFERENT_PRODUCT_SIZE = 3;

    #[ORM\Id]
    #[ORM\Column]
    private string $id;

    #[ORM\ManyToMany(targetEntity: ShoppingCartLine::class, cascade: ['persist'])]
    private Collection $items;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    public function __construct(string $id)
    {
        $this->id = $id;
        $this->items = new ArrayCollection();
        $this->createdAt = new \DateTimeImmutable();
    }

    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return Collection<int, ShoppingCartLine>
     */
    public function getItems(): Collection
    {
        return $this->items;
    }

    public function addItem(ShoppingCartLine $item): void
    {
        if ($this->items->contains($item)) {
            return;
        }

        if (self::MAX_DIFFERENT_PRODUCT_SIZE < $this->items->count() + 1) {
            throw new ShoppingCartExceedsSizeException();
        }

        $this->items->add($item);
    }

    public function removeItem(ShoppingCartLine $item): void
    {
        $this->items->removeElement($item);
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getPriceSum(): float
    {
        return $this->getItems()->reduce(function (float $accumulator, ShoppingCartLine $item) {
            return \bcadd(bcmul($item->getProduct()->getPrice(), $item->getQuantity(), 2), $accumulator, 2);
        }, 0);
    }
}
