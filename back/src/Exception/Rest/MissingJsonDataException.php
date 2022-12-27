<?php

namespace App\Exception\Rest;

class MissingJsonDataException extends \RuntimeException implements RestExceptionInterface
{
    public function __construct(string $property, string $dtoFqcn)
    {
        parent::__construct(sprintf(
            'Missing property "%s" for "%s".',
            $property,
            $dtoFqcn
        ));
    }
}
