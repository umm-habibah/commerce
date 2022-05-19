<?php

namespace App\Tests;

use App\Entity\Detail;
use App\Entity\Order;
use App\Entity\User;
use DateTime;
use PHPUnit\Framework\TestCase;

class OrderTest extends TestCase
{
    public function testIsTrue(): void
    {
        $order = new Order();
        $date = new DateTime();
        $user = new User();

        $order->setReference('reference')
              ->setCarrierName('name')
              ->setCarrierPrice(1234)
              ->setState(0)
              ->setAddress('address')
              ->setStripe('stripe')
              ->setCreatedAt($date)
              ->setUser($user);

        $this->assertTrue($order->getReference() === 'reference');
        $this->assertTrue($order->getCarrierName() === 'name');
        $this->assertTrue($order->getCarrierPrice() == 1234);
        $this->assertTrue($order->getState() == 0);
        $this->assertTrue($order->getAddress() === 'address');
        $this->assertTrue($order->getStripe() === 'stripe');
        $this->assertTrue($order->getCreatedAt() === $date);
        $this->assertTrue($order->getUser() === $user);
    }

    public function testIsFalse(): void
    {
        $order = new Order();
        $date = new DateTime();
        $user = new User();

        $order->setReference('reference')
              ->setCarrierName('name')
              ->setCarrierPrice(1234)
              ->setState(0)
              ->setAddress('address')
              ->setStripe('stripe')
              ->setCreatedAt($date)
              ->setUser($user);

        $this->assertFalse($order->getReference() === 'false');
        $this->assertFalse($order->getCarrierName() === 'false');
        $this->assertFalse($order->getCarrierPrice() == 123);
        $this->assertFalse($order->getState() == 1);
        $this->assertFalse($order->getAddress() === 'false');
        $this->assertFalse($order->getStripe() === 'false');
        $this->assertFalse($order->getCreatedAt() === new DateTime());
        $this->assertFalse($order->getUser() === new User());
    }

    public function testIsEmpty(): void
    {
        $order = new Order();

        $this->assertEmpty($order->getReference());
        $this->assertEmpty($order->getCarrierName());
        $this->assertEmpty($order->getCarrierPrice());
        $this->assertEmpty($order->getState());
        $this->assertEmpty($order->getAddress());
        $this->assertEmpty($order->getStripe());
        $this->assertEmpty($order->getCreatedAt());
        $this->assertEmpty($order->getUser());
        $this->assertEmpty($order->getId());
    }

    public function testAddRemoveDetail(): void
    {
        $order = new Order();
        $detail = new Detail();

        $this->assertEmpty($order->getDetails());

        $order->addDetail($detail);
        $this->assertContains($detail, $order->getDetails());

        $order->removeDetail($detail);
        $this->assertEmpty($order->getDetails());
    }
}
