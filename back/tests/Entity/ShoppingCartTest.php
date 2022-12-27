<?php

namespace App\Tests\Entity;

use App\Entity\Product;
use App\Entity\ShoppingCart;
use App\Entity\ShoppingCartLine;
use App\Exception\ShoppingCart\ShoppingCartExceedsSizeException;
use PHPUnit\Framework\TestCase;

class ShoppingCartTest extends TestCase
{
    public function testShoppingCartWillThrowExceptionWhenExceedsItsSize(): void
    {
        $this->expectException(ShoppingCartExceedsSizeException::class);

        $shoppingCart = new ShoppingCart('testId');
        for ($i = 0; $i < ShoppingCart::MAX_DIFFERENT_PRODUCT_SIZE + 1; ++$i) {
            $line = $this->createLine($i, 1, 1.23);

            $shoppingCart->addItem($line);
        }
    }

    public function testShoppingCartSumShouldReturnValidPriceSum(): void
    {
        $shoppingCart = new ShoppingCart('testId');

        $line = $this->createLine(1, 2, 1.23);
        $shoppingCart->addItem($line);

        $line = $this->createLine(1, 2, 1.20);
        $shoppingCart->addItem($line);

        $this->assertEquals(4.86, $shoppingCart->getPriceSum());
    }

    private function createLine(int $id, int $quantity, float $price): ShoppingCartLine
    {
        $line = new ShoppingCartLine(
            sprintf('testId%d', $id),
        );
        $line->setProduct(new Product(
            sprintf('testId%d', $id),
            sprintf('testTitle%d', $id),
            $price
        ));
        $line->setQuantity($quantity);

        return $line;
    }
}
