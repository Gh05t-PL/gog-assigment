<?php

namespace App\CQRS\Command\ShoppingCart\CreateShoppingCart;

use App\CQRS\Bus\CommandHandlerInterface;
use App\Entity\ShoppingCart;
use App\Repository\ShoppingCartRepository;

class CreateShoppingCartHandler implements CommandHandlerInterface
{
    private ShoppingCartRepository $shoppingCartRepository;

    public function __construct(ShoppingCartRepository $shoppingCartRepository)
    {
        $this->shoppingCartRepository = $shoppingCartRepository;
    }

    public function __invoke(CreateShoppingCartCommand $command)
    {
        $shoppingCart = new ShoppingCart(
            $command->getId(),
        );

        $this->shoppingCartRepository->save($shoppingCart, true);
    }
}
