<?php

namespace App\CQRS\Command\Product\UpdateProduct;

use App\CQRS\Bus\CommandHandlerInterface;
use App\Exception\Product\ProductNameNotUnique;
use App\Exception\Shared\NotFoundException;
use App\Repository\ProductRepository;

class UpdateProductHandler implements CommandHandlerInterface
{
    private ProductRepository $productRepository;

    public function __construct(
        ProductRepository $productRepository
    ) {
        $this->productRepository = $productRepository;
    }

    public function __invoke(UpdateProductCommand $command)
    {
        $product = $this->productRepository->find($command->getId());
        if (null === $product) {
            throw new NotFoundException('Product');
        }

        $productWithSameTitle = $this->productRepository->findOneBy(['title' => $command->getTitle()]);
        if (null !== $productWithSameTitle && $productWithSameTitle->getId() !== $command->getId()) {
            throw new ProductNameNotUnique();
        }

        $product->setTitle($command->getTitle());
        $product->changePrice($command->getPrice());

        $this->productRepository->save($product, true);
    }
}
