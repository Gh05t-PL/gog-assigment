<?php

namespace App\Controller;

use App\CQRS\Command\ShoppingCart\AddProductToShoppingCart\AddProductToShoppingCartCommand;
use App\CQRS\Command\ShoppingCart\CreateShoppingCart\CreateShoppingCartCommand;
use App\CQRS\Command\ShoppingCart\RemoveLineFromShoppingCart\RemoveLineFromShoppingCartCommand;
use App\CQRS\Query\ShoppingCart\FetchShoppingCartDetails\FetchShoppingCartDetailsQuery;
use App\DTO\Incoming\AddProductToCartDTO;
use App\DTO\Outcoming\Product\ProductIdDTO;
use App\DTO\Outcoming\ShoppingCart\ShoppingCartIdDTO;
use App\Exception\SpecificationException;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ShoppingCartRestController extends AbstractRestController
{
    #[Route(
        path: '/api/v1/shopping-cart',
        methods: ['POST']
    )]
    public function create(Request $request): JsonResponse
    {
        $id = Uuid::uuid4();

        $this->execute(new CreateShoppingCartCommand($id));

        $outcomingDto = new ShoppingCartIdDTO($id);

        return new JsonResponse(
            $this->dtoToJson($outcomingDto),
            Response::HTTP_CREATED,
            json: true
        );
    }

    #[Route(
        path: '/api/v1/shopping-cart/{id}/product',
        requirements: [
            'id' => self::UUID_REGEX,
        ],
        methods: ['POST']
    )]
    public function update(Request $request, string $id): JsonResponse
    {
        /** @var AddProductToCartDTO $dto */
        $dto = $this->jsonToDto(
            $request->getContent(),
            AddProductToCartDTO::class
        );

        try {
            $this->execute(new AddProductToShoppingCartCommand(
                $id,
                $dto->getProductId(),
                $dto->getQuantity()
            ));
        } catch (SpecificationException $e) {
            return new JsonResponse(
                $this->exceptionToJson($e),
                Response::HTTP_BAD_REQUEST,
                json: true
            );
        }

        $outcomingDto = new ProductIdDTO($id);

        return new JsonResponse(
            $this->dtoToJson($outcomingDto),
            Response::HTTP_OK,
            json: true
        );
    }

    #[Route(
        path: '/api/v1/shopping-cart-line/{id}',
        requirements: [
            'id' => self::UUID_REGEX,
        ],
        methods: ['DELETE']
    )]
    public function delete(string $id): Response
    {
        $this->execute(new RemoveLineFromShoppingCartCommand(
            $id
        ));

        return new Response('', Response::HTTP_NO_CONTENT);
    }

    #[Route(
        path: '/api/v1/shopping-cart/{id}',
        requirements: [
            'id' => self::UUID_REGEX,
        ],
        methods: ['GET']
    )]
    public function detail(string $id): JsonResponse
    {
        $outcomingDto = $this->ask(new FetchShoppingCartDetailsQuery($id));

        return new JsonResponse(
            $this->dtoToJson($outcomingDto),
            Response::HTTP_OK,
            json: true
        );
    }
}
