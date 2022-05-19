<?php

namespace App\Tests;

use App\Entity\Detail;
use App\Entity\Order;
use PHPUnit\Framework\TestCase;

class DetailTest extends TestCase
{
    public function testIsTrue(): void
    {
        $detail = new Detail();
        $order = new Order();

        $detail->setPrice(1234)
               ->setProduct('product')
               ->setQuantity(1)
               ->setTotal(1234)
               ->setTheOrder($order);

        $this->assertTrue($detail->getPrice() == 1234);
        $this->assertTrue($detail->getProduct() === 'product');
        $this->assertTrue($detail->getQuantity() == 1);
        $this->assertTrue($detail->getTotal() == 1234);
        $this->assertTrue($detail->getTheOrder() === $order);
    }

    public function testIsFalse(): void
    {
        $detail = new Detail();
        $order = new Order();

        $detail->setPrice(1234)
               ->setProduct('product')
               ->setQuantity(1)
               ->setTotal(1234)
               ->setTheOrder($order);

        $this->assertFalse($detail->getPrice() == 123);
        $this->assertFalse($detail->getProduct() === 'false');
        $this->assertFalse($detail->getQuantity() == 2);
        $this->assertFalse($detail->getTotal() == 123);
        $this->assertFalse($detail->getTheOrder() === new Order());
    }

    public function testIsEmpty(): void
    {
        $detail = new Detail();

        $this->assertEmpty($detail->getPrice());
        $this->assertEmpty($detail->getProduct());
        $this->assertEmpty($detail->getQuantity());
        $this->assertEmpty($detail->getTotal());
        $this->assertEmpty($detail->getTheOrder());
        $this->assertEmpty($detail->getId());
    }
}
