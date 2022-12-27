<?php

namespace App\Controller;

use App\CQRS\Bus\CommandBus;
use App\CQRS\Bus\CommandInterface;
use App\CQRS\Bus\QueryBus;
use App\CQRS\Bus\QueryInterface;
use App\DTO\Outcoming\ExceptionDTO;
use App\DTO\Outcoming\OutcomingDTO;
use App\Exception\Rest\InvalidJsonException;
use App\Exception\Rest\MissingJsonDataException;
use App\Exception\Rest\ValidationException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\Exception\MissingConstructorArgumentsException;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;
use Symfony\Component\Serializer\Normalizer\AbstractObjectNormalizer;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

abstract class AbstractRestController extends AbstractController
{
    public const UUID_REGEX = '^[0-9(a-f|A-F)]{8}-[0-9(a-f|A-F)]{4}-4[0-9(a-f|A-F)]{3}-[89ab][0-9(a-f|A-F)]{3}-[0-9(a-f|A-F)]{12}$';

    private SerializerInterface $serializer;
    private ValidatorInterface $validator;
    private CommandBus $commandBus;
    private QueryBus $queryBus;

    public function __construct(
        SerializerInterface $serializer,
        ValidatorInterface $validator,
        CommandBus $commandBus,
        QueryBus $queryBus
    ) {
        $this->serializer = $serializer;
        $this->validator = $validator;
        $this->commandBus = $commandBus;
        $this->queryBus = $queryBus;
    }

    public function dtoToJson(OutcomingDTO $dto)
    {
        return $this->serializer->serialize(
            $dto,
            'json'
        );
    }

    public function jsonToDto(string $json, string $dtoFqcn)
    {
        try {
            $dto = $this->serializer->deserialize(
                $json,
                $dtoFqcn,
                'json',
                [AbstractObjectNormalizer::DISABLE_TYPE_ENFORCEMENT => true]
            );

            $violations = $this->validator->validate($dto);

            if (0 < $violations->count()) {
                throw new ValidationException($violations);
            }

            return $dto;
        } catch (NotEncodableValueException $e) {
            throw new InvalidJsonException();
        } catch (MissingConstructorArgumentsException $e) {
            throw new MissingJsonDataException($e->getMissingConstructorArguments()[0], $dtoFqcn);
        }
    }

    public function exceptionToJson(\Exception $exception)
    {
        return $this->serializer->serialize(
            new ExceptionDTO($exception),
            'json'
        );
    }

    public function ask(QueryInterface $query, array $stamps = []): mixed
    {
        return $this->queryBus->ask($query, $stamps);
    }

    public function execute(CommandInterface $command): void
    {
        $this->commandBus->execute($command);
    }
}
