<?php

namespace App\Tests;

use App\Entity\Address;
use App\Entity\User;
use PHPUnit\Framework\TestCase;

class AddressTest extends TestCase
{
    public function testIsTrue(): void
    {
        $address = new Address();
        $user = new User();

        $address->setLastname('lastname')
                ->setFirstname('firstname')
                ->setName('name')
                ->setAddress('address')
                ->setCity('city')
                ->setCountry('country')
                ->setZipcode('zipcode')
                ->setPhone('phone')
                ->setUser($user);

        $this->assertTrue($address->getLastname() === 'lastname');
        $this->assertTrue($address->getFirstname() === 'firstname');
        $this->assertTrue($address->getName() === 'name');
        $this->assertTrue($address->getAddress() === 'address');
        $this->assertTrue($address->getCity() === 'city');
        $this->assertTrue($address->getCountry() === 'country');
        $this->assertTrue($address->getZipcode() === 'zipcode');
        $this->assertTrue($address->getPhone() === 'phone');
        $this->assertTrue($address->getUser() === $user);
    }

    public function testIsFalse(): void
    {
        $address = new Address();
        $user = new User();

        $address->setLastname('lastname')
                ->setFirstname('firstname')
                ->setName('name')
                ->setAddress('address')
                ->setCity('city')
                ->setCountry('country')
                ->setZipcode('zipcode')
                ->setPhone('phone')
                ->setUser($user);

        $this->assertFalse($address->getLastname() === 'false');
        $this->assertFalse($address->getFirstname() === 'false');
        $this->assertFalse($address->getName() === 'false');
        $this->assertFalse($address->getAddress() === 'false');
        $this->assertFalse($address->getCity() === 'false');
        $this->assertFalse($address->getCountry() === 'false');
        $this->assertFalse($address->getZipcode() === 'false');
        $this->assertFalse($address->getPhone() === 'false');
        $this->assertFalse($address->getUser() === new User());
    }

    public function testIsEmpty(): void
    {
        $address = new Address();

        $this->assertEmpty($address->getLastname());
        $this->assertEmpty($address->getFirstname());
        $this->assertEmpty($address->getName());
        $this->assertEmpty($address->getAddress());
        $this->assertEmpty($address->getCity());
        $this->assertEmpty($address->getCountry());
        $this->assertEmpty($address->getZipcode());
        $this->assertEmpty($address->getPhone());
        $this->assertEmpty($address->getUser());
        $this->assertEmpty($address->getId());
    }
}
