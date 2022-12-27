<?php

namespace App\CQRS\Command\ShoppingCart\AddProductToShoppingCart;

use App\CQRS\Bus\CommandHandlerInterface;
use App\Entity\ShoppingCart;
use App\Entity\ShoppingCartLine;
use App\Exception\Shared\NotFoundException;
use App\Repository\ProductRepository;
use App\Repository\ShoppingCartRepository;
use Ramsey\Uuid\Uuid;

class AddProductToShoppingCartHandler implements CommandHandlerInterface
{
    private ShoppingCartRepository $shoppingCartRepository;
    private ProductRepository $productRepository;

    public function __construct(
        ShoppingCartRepository $shoppingCartRepository,
        ProductRepository $productRepository
    ) {
        $this->shoppingCartRepository = $shoppingCartRepository;
        $this->productRepository = $productRepository;
    }

    public function __invoke(AddProductToShoppingCartCommand $command)
    {
        $shoppingCart = $this->shoppingCartRepository->find($command->getShoppingCartId());
        if (null === $shoppingCart) {
            throw new NotFoundException('ShoppingCart');
        }

        $product = $this->productRepository->find($command->getProductId());
        if (null === $product) {
            throw new NotFoundException('Product');
        }

        $lineWithProduct = $this->findProductInShoppingCart($shoppingCart, $command->getProductId());

        if (null !== $lineWithProduct) {
            $lineWithProduct->setQuantity($command->getQuantity() + $lineWithProduct->getQuantity());
        } else {
            $line = new ShoppingCartLine(Uuid::uuid4());
            $line
                ->setProduct($product)
                ->setQuantity($command->getQuantity());

            $shoppingCart->addItem($line);
        }

        $this->shoppingCartRepository->save($shoppingCart, true);
    }

    private function findProductInShoppingCart(ShoppingCart $shoppingCart, string $productId)
    {
        return $shoppingCart->getItems()->findFirst(function (int $idx, ShoppingCartLine $cartLine) use ($productId) {
            if ($cartLine->getProduct()->getId() === $productId) {
                return $cartLine;
            }

            return null;
        });
    }
}
