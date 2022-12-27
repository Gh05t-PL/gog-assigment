<?php

namespace App\Exception\ShoppingCart;

use App\Entity\ShoppingCartLine;
use App\Exception\SpecificationException;

class ShoppingCartLineExceedsProductQuantityException extends SpecificationException
{
    public function __construct()
    {
        parent::__construct(
            sprintf(
                'Shopping cart line exceeds product quantity of %s',
                ShoppingCartLine::MAX_SAME_PRODUCT_SIZE
            )
        );
    }
}
