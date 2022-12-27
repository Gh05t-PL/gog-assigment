<?php

namespace App\CQRS\Command\Product\CreateProduct;

use App\CQRS\Bus\CommandHandlerInterface;
use App\Entity\Product;
use App\Exception\Product\ProductNameNotUnique;
use App\Repository\ProductRepository;

class CreateProductHandler implements CommandHandlerInterface
{
    private ProductRepository $productRepository;

    public function __construct(
        ProductRepository $productRepository
    ) {
        $this->productRepository = $productRepository;
    }

    public function __invoke(CreateProductCommand $command)
    {
        if (!empty($this->productRepository->findBy(['title' => $command->getTitle()]))) {
            throw new ProductNameNotUnique();
        }

        $product = new Product(
            $command->getId(),
            $command->getTitle(),
            $command->getPrice(),
        );

        $this->productRepository->save($product, true);
    }
}
