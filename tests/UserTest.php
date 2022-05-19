<?php

namespace App\Tests;

use App\Entity\Address;
use App\Entity\Order;
use App\Entity\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function testIsTrue(): void
    {
        $user = new User();

        $user->setEmail('true@email.com')
             ->setRoles(['ROLE_USER', 'ROLE_TEST'])
             ->setPassword('password')
             ->setLastname('lastname')
             ->setFirstname('firstname');

        $this->assertTrue($user->getEmail() === 'true@email.com');
        $this->assertTrue($user->getRoles() === ['ROLE_USER', 'ROLE_TEST']);
        $this->assertTrue($user->getPassword() === 'password');
        $this->assertTrue($user->getLastname() === 'lastname');
        $this->assertTrue($user->getFirstname() === 'firstname');
    }

    public function testIsFalse(): void
    {
        $user = new User();

        $user->setEmail('true@email.com')
             ->setPassword('password')
             ->setLastname('lastname')
             ->setFirstname('firstname');

        $this->assertFalse($user->getEmail() === 'false@email.com');
        $this->assertFalse($user->getPassword() === 'false');
        $this->assertFalse($user->getLastname() === 'false');
        $this->assertFalse($user->getFirstname() === 'false');
    }

    public function testIsEmpty(): void
    {
        $user = new User();

        $this->assertEmpty($user->getEmail());
        $this->assertEmpty($user->getPassword());
        $this->assertEmpty($user->getLastname());
        $this->assertEmpty($user->getFirstname());
        $this->assertEmpty($user->getId());
    }

    public function testAddRemoveAddress(): void
    {
        $user = new User();
        $address = new Address();

        $this->assertEmpty($user->getAddresses());

        $user->addAddress($address);
        $this->assertContains($address, $user->getAddresses());

        $user->removeAddress($address);
        $this->assertEmpty($user->getAddresses());
    }

    public function testAddRemoveOrder(): void
    {
        $user = new User();
        $order = new Order();

        $this->assertEmpty($user->getOrders());

        $user->addOrder($order);
        $this->assertContains($order, $user->getOrders());

        $user->removeOrder($order);
        $this->assertEmpty($user->getOrders());
    }
}
