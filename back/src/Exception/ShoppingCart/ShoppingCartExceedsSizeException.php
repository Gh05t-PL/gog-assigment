<?php

namespace App\Exception\ShoppingCart;

use App\Entity\ShoppingCart;
use App\Exception\SpecificationException;

class ShoppingCartExceedsSizeException extends SpecificationException
{
    public function __construct()
    {
        parent::__construct(
            sprintf('Shopping cart exceeds size of %s', ShoppingCart::MAX_DIFFERENT_PRODUCT_SIZE)
        );
    }
}
