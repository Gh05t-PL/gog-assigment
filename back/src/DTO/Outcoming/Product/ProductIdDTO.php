<?php

namespace App\DTO\Outcoming\Product;

use App\DTO\Outcoming\OutcomingDTO;

class ProductIdDTO implements OutcomingDTO
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
