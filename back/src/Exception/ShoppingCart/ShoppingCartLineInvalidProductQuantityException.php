<?php

namespace App\Exception\ShoppingCart;

use App\Exception\SpecificationException;

class ShoppingCartLineInvalidProductQuantityException extends SpecificationException
{
    public function __construct()
    {
        parent::__construct('Shopping cart line has invalid product quantity');
    }
}
