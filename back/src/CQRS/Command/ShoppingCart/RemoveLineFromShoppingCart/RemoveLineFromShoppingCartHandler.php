<?php

namespace App\CQRS\Command\ShoppingCart\RemoveLineFromShoppingCart;

use App\CQRS\Bus\CommandHandlerInterface;
use App\Exception\Shared\NotFoundException;
use App\Repository\ShoppingCartLineRepository;

class RemoveLineFromShoppingCartHandler implements CommandHandlerInterface
{
    private ShoppingCartLineRepository $shoppingCartLineRepository;

    public function __construct(ShoppingCartLineRepository $shoppingCartLineRepository)
    {
        $this->shoppingCartLineRepository = $shoppingCartLineRepository;
    }

    public function __invoke(RemoveLineFromShoppingCartCommand $command)
    {
        $cartLine = $this->shoppingCartLineRepository->find($command->getId());

        if (null === $cartLine) {
            throw new NotFoundException('ShoppingCartLine');
        }

        $this->shoppingCartLineRepository->remove($cartLine, true);
    }
}
