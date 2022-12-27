<?php

namespace App\DTO\Incoming;

use Symfony\Component\Validator\Constraints as Assert;

class AddProductToCartDTO
{
    #[Assert\NotBlank()]
    #[Assert\Type(type: 'string')]
    #[Assert\Regex(pattern: '/^[0-9(a-f|A-F)]{8}-[0-9(a-f|A-F)]{4}-4[0-9(a-f|A-F)]{3}-[89ab][0-9(a-f|A-F)]{3}-[0-9(a-f|A-F)]{12}$/')]
    private mixed $productId;

    #[Assert\NotBlank()]
    #[Assert\Type(type: 'integer')]
    #[Assert\GreaterThan(value: 0)]
    private mixed $quantity;

    public function __construct(mixed $productId, mixed $quantity)
    {
        $this->productId = $productId;
        $this->quantity = $quantity;
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
