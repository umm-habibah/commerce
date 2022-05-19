<?php

namespace App\Tests;

use App\Entity\ForgotPassword;
use App\Entity\User;
use DateTime;
use PHPUnit\Framework\TestCase;

class ForgotPasswordTest extends TestCase
{
    public function testIsTrue(): void
    {
        $password = new ForgotPassword();
        $user = new User();
        $date = new DateTime();

        $password->setToken('token')
                 ->setCreatedAt($date)
                 ->setUser($user);

        $this->assertTrue($password->getToken() === 'token');
        $this->assertTrue($password->getCreatedAt() === $date);
        $this->assertTrue($password->getUser() === $user);
    }

    public function testIsFalse(): void
    {
        $password = new ForgotPassword();
        $user = new User();
        $date = new DateTime();

        $password->setToken('token')
                 ->setCreatedAt($date)
                 ->setUser($user);

        $this->assertFalse($password->getToken() === 'false');
        $this->assertFalse($password->getCreatedAt() === new DateTime());
        $this->assertFalse($password->getUser() === new User());
    }

    public function testIsEmpty(): void
    {
        $password = new ForgotPassword();

        $this->assertEmpty($password->getToken());
        $this->assertEmpty($password->getCreatedAt());
        $this->assertEmpty($password->getUser());
        $this->assertEmpty($password->getId());
    }
}
