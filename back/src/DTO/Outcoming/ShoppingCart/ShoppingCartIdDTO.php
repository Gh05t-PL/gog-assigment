<?php

namespace App\DTO\Outcoming\ShoppingCart;

use App\DTO\Outcoming\OutcomingDTO;

class ShoppingCartIdDTO implements OutcomingDTO
{
    private string $id;

    public function __construct(
        string $id
    ) {
        $this->id = $id;
    }

    public function getId(): string
    {
        return $this->id;
    }
}
