<?php

namespace App\Exception\Product;

use App\Exception\SpecificationException;

class ProductNameNotUnique extends SpecificationException
{
    public function __construct()
    {
        parent::__construct('Product name not unique');
    }
}
