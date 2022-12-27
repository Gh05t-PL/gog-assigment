<?php

namespace App\CQRS\Command\Product\DeleteProduct;

class DeleteProductCommand implements \App\CQRS\Bus\CommandInterface
{
    private string $id;

    public function __construct(
        string $id,
    ) {
        $this->id = $id;
    }

    public function getId(): string
    {
        return $this->id;
    }
}
