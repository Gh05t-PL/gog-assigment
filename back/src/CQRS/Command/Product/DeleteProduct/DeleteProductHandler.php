<?php

namespace App\CQRS\Command\Product\DeleteProduct;

use App\CQRS\Bus\CommandHandlerInterface;
use App\Exception\Shared\NotFoundException;
use App\Repository\ProductRepository;

class DeleteProductHandler implements CommandHandlerInterface
{
    private ProductRepository $productRepository;

    public function __construct(
        ProductRepository $productRepository
    ) {
        $this->productRepository = $productRepository;
    }

    public function __invoke(DeleteProductCommand $command)
    {
        $product = $this->productRepository->find($command->getId());
        if (null === $product) {
            throw new NotFoundException('Product');
        }

        $this->productRepository->remove($product, true);
    }
}
