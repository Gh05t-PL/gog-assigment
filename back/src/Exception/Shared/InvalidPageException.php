<?php

namespace App\Exception\Shared;

class InvalidPageException extends \RuntimeException
{
    public function __construct()
    {
        parent::__construct('Invalid page number provided.');
    }
}
