<?php

namespace App\Tests;

use App\Entity\Carrier;
use PHPUnit\Framework\TestCase;

class CarrierTest extends TestCase
{
    public function testIsTrue(): void
    {
        $carrier = new Carrier();

        $carrier->setName('name')
                ->setDescription('description')
                ->setPrice(1234);

        $this->assertTrue($carrier->getName() === 'name');
        $this->assertTrue($carrier->getDescription() === 'description');
        $this->assertTrue($carrier->getPrice() == 1234);
    }

    public function testIsFalse(): void
    {
        $carrier = new Carrier();

        $carrier->setName('name')
                ->setDescription('description')
                ->setPrice(1234);

        $this->assertFalse($carrier->getName() === 'false');
        $this->assertFalse($carrier->getDescription() === 'false');
        $this->assertFalse($carrier->getPrice() == 123);
    }

    public function testIsEmpty(): void
    {
        $carrier = new Carrier();

        $this->assertEmpty($carrier->getName());
        $this->assertEmpty($carrier->getDescription());
        $this->assertEmpty($carrier->getPrice());
        $this->assertEmpty($carrier->getId());
    }
}
