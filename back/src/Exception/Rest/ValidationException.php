<?php

namespace App\Exception\Rest;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class ValidationException extends \RuntimeException implements RestExceptionInterface
{
    /**
     * @var ConstraintViolationListInterface
     */
    private $violations;

    /**
     * ValidationException constructor.
     *
     * @param string $message
     * @param int    $code
     */
    public function __construct(ConstraintViolationListInterface $violations)
    {
        parent::__construct();
        $this->violations = $violations;
    }

    public function getResponse(): JsonResponse
    {
        return new JsonResponse(
            $this->getNormalizedViolations(),
            Response::HTTP_UNPROCESSABLE_ENTITY,
        );
    }

    public function getNormalizedViolations(): array
    {
        return $this->normalizeViolations($this->violations);
    }

    protected function normalizeViolations(ConstraintViolationListInterface $violations): array
    {
        $formattedViolationList = [];
        for ($i = 0; $i < $violations->count(); ++$i) {
            $violation = $violations->get($i);
            $formattedViolationList[] = [
                'property' => $violation->getPropertyPath(),
                'message' => $violation->getMessage(),
                'code' => $violation->getCode(),
            ];
        }

        return $formattedViolationList;
    }
}
