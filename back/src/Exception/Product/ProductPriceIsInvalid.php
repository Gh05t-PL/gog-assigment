<?php

namespace App\Exception\Product;

use App\Exception\SpecificationException;

class ProductPriceIsInvalid extends SpecificationException
{
    public function __construct()
    {
        parent::__construct('Product price is invalid');
    }
}
