<?php

namespace App\Tests\Entity;

use App\Entity\Product;
use App\Exception\Product\ProductPriceIsInvalid;
use PHPUnit\Framework\TestCase;

class ProductTest extends TestCase
{
    public function testProductConstructorGivenInvalidPriceHavingMoreThenTwoDecimalDigitsShouldThrowException(): void
    {
        $this->expectException(ProductPriceIsInvalid::class);

        $product = new Product('testId', 'test', 1.234);
    }

    public function testProductChangePriceGivenInvalidPriceHavingMoreThenTwoDecimalDigitsShouldThrowException(): void
    {
        $this->expectException(ProductPriceIsInvalid::class);

        $product = new Product('testId', 'test', 1.23);
        $product->changePrice(1.234);
    }

    public function testProductConstructorGivenInvalidPriceBeingEqualOrLowerThenZeroShouldThrowException(): void
    {
        $this->expectException(ProductPriceIsInvalid::class);

        $product = new Product('testId', 'test', 0);
    }

    public function testProductChangePriceGivenInvalidPriceBeingEqualOrLowerThenZeroShouldThrowException(): void
    {
        $this->expectException(ProductPriceIsInvalid::class);

        $product = new Product('testId', 'test', 1.23);
        $product->changePrice(0);
    }
}
