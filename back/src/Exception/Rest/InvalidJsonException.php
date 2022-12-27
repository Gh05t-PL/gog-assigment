<?php

namespace App\Exception\Rest;

class InvalidJsonException extends \RuntimeException implements RestExceptionInterface
{
    public function __construct()
    {
        parent::__construct('Invalid json sent.');
    }
}
