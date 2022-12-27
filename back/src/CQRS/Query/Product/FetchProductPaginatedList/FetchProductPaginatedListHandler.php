<?php

namespace App\CQRS\Query\Product\FetchProductPaginatedList;

use App\CQRS\Bus\QueryHandlerInterface;
use App\DTO\Outcoming\PaginatedDTO;
use App\DTO\Outcoming\Product\SingleProductDTO;
use App\Entity\Product;
use App\Exception\Shared\InvalidPageException;
use App\Repository\ProductRepository;

class FetchProductPaginatedListHandler implements QueryHandlerInterface
{
    private ProductRepository $productRepository;

    public function __construct(
        ProductRepository $productRepository
    ) {
        $this->productRepository = $productRepository;
    }

    public function __invoke(FetchProductPaginatedListQuery $query): PaginatedDTO
    {
        [$items, $total] = $this->productRepository->findPaginated($query->getPage());
        $totalPages = ceil($total / ProductRepository::MAX_PER_PAGE);

        if ($query->getPage() > $totalPages) {
            throw new InvalidPageException();
        }

        $items = array_map(fn (Product $item) => $this->mapProductToDto($item), $items);

        return $this->mapDtosToPaginated(
            $query->getPage(),
            $total,
            ProductRepository::MAX_PER_PAGE,
            $totalPages,
            $items
        );
    }

    private function mapProductToDto(Product $product): SingleProductDTO
    {
        return new SingleProductDTO(
            $product->getId(),
            $product->getTitle(),
            $product->getPrice(),
        );
    }

    private function mapDtosToPaginated(int $page, int $total, int $perPage, int $totalPages, array $items): PaginatedDTO
    {
        return new PaginatedDTO(
            $page,
            $perPage,
            $totalPages,
            $total,
            $items
        );
    }
}
