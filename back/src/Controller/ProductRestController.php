<?php

namespace App\Controller;

use App\CQRS\Command\Product\CreateProduct\CreateProductCommand;
use App\CQRS\Command\Product\DeleteProduct\DeleteProductCommand;
use App\CQRS\Command\Product\UpdateProduct\UpdateProductCommand;
use App\CQRS\Query\Product\FetchProductPaginatedList\FetchProductPaginatedListQuery;
use App\DTO\Incoming\CreateProductDTO;
use App\DTO\Incoming\UpdateProductDTO;
use App\DTO\Outcoming\Product\ProductIdDTO;
use App\Exception\Shared\InvalidPageException;
use App\Exception\SpecificationException;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductRestController extends AbstractRestController
{
    #[Route(
        path: '/api/v1/product',
        methods: ['POST']
    )]
    public function create(Request $request): JsonResponse
    {
        /** @var CreateProductDTO $dto */
        $dto = $this->jsonToDto(
            $request->getContent(),
            CreateProductDTO::class
        );

        $id = Uuid::uuid4();
        try {
            $this->execute(new CreateProductCommand(
                $id,
                $dto->getTitle(),
                $dto->getPrice()
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
            Response::HTTP_CREATED,
            json: true
        );
    }

    #[Route(
        path: '/api/v1/product/{id}',
        requirements: [
            'id' => self::UUID_REGEX,
        ],
        methods: ['PUT']
    )]
    public function update(Request $request, string $id): JsonResponse
    {
        /** @var UpdateProductDTO $dto */
        $dto = $this->jsonToDto(
            $request->getContent(),
            UpdateProductDTO::class
        );

        try {
            $this->execute(new UpdateProductCommand(
                $id,
                $dto->getTitle(),
                $dto->getPrice()
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
        path: '/api/v1/product/{id}',
        requirements: [
            'id' => self::UUID_REGEX,
        ],
        methods: ['DELETE']
    )]
    public function delete(string $id): Response
    {
        $this->execute(new DeleteProductCommand(
            $id
        ));

        return new Response('', Response::HTTP_NO_CONTENT);
    }

    #[Route(
        path: '/api/v1/product',
        methods: ['GET']
    )]
    public function list(Request $request): JsonResponse
    {
        $page = $request->query->get('page', 1);

        if (1 > $page) {
            throw new InvalidPageException();
        }

        $outcomingDto = $this->ask(new FetchProductPaginatedListQuery($page));

        return new JsonResponse(
            $this->dtoToJson($outcomingDto),
            Response::HTTP_OK,
            json: true
        );
    }
}
