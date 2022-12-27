<?php

namespace App\Exception\Shared;

class NotFoundException extends \RuntimeException
{
    public function __construct(string $resource)
    {
        parent::__construct(sprintf('Resource "%s" not found', $resource));
    }
}
