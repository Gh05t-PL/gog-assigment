<?php

namespace App\CQRS\Query\ShoppingCart\FetchShoppingCartDetails;

use App\CQRS\Bus\QueryHandlerInterface;
use App\DTO\Outcoming\ShoppingCart\ShoppingCartDTO;
use App\DTO\Outcoming\ShoppingCart\ShoppingCartLineDTO;
use App\Entity\ShoppingCart;
use App\Entity\ShoppingCartLine;
use App\Exception\Shared\NotFoundException;
use App\Repository\ShoppingCartRepository;

class FetchShoppingCartDetailsHandler implements QueryHandlerInterface
{
    private ShoppingCartRepository $shoppingCartRepository;

    public function __construct(
        ShoppingCartRepository $shoppingCartRepository
    ) {
        $this->shoppingCartRepository = $shoppingCartRepository;
    }

    public function __invoke(FetchShoppingCartDetailsQuery $query): ShoppingCartDTO
    {
        $shoppingCart = $this->shoppingCartRepository->find($query->getId());

        if (null === $shoppingCart) {
            throw new NotFoundException('ShoppingCart');
        }

        return $this->mapCartToDto($shoppingCart);
    }

    private function mapCartToDto(ShoppingCart $shoppingCart): ShoppingCartDTO
    {
        $lines = $shoppingCart->getItems()
            ->map(fn (ShoppingCartLine $cartLine) => $this->mapLinesToDto($cartLine))
            ->toArray();

        return new ShoppingCartDTO(
            $shoppingCart->getId(),
            $lines,
            $shoppingCart->getPriceSum()
        );
    }

    private function mapLinesToDto(ShoppingCartLine $cartLine): ShoppingCartLineDTO
    {
        return new ShoppingCartLineDTO(
            $cartLine->getId(),
            $cartLine->getProduct()->getId(),
            $cartLine->getProduct()->getTitle(),
            $cartLine->getProduct()->getPrice(),
            $cartLine->getQuantity()
        );
    }
}
