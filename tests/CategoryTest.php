<?php

namespace App\Tests;

use App\Entity\Category;
use App\Entity\Product;
use PHPUnit\Framework\TestCase;

class CategoryTest extends TestCase
{
    public function testIsTrue(): void
    {
        $category = new Category();

        $category->setName('name');

        $this->assertTrue($category->getName() === 'name');
    }

    public function testIsFalse(): void
    {
        $category = new Category();

        $category->setName('name');

        $this->assertFalse($category->getName() === 'false');
    }

    public function testIsEmpty(): void
    {
        $category = new Category();

        $this->assertEmpty($category->getName());
        $this->assertEmpty($category->getId());
    }

    public function testAddRemoveProduct(): void
    {
        $category = new Category();
        $product = new Product();

        $this->assertEmpty($category->getProducts());

        $category->addProduct($product);
        $this->assertContains($product, $category->getProducts());

        $category->removeProduct($product);
        $this->assertEmpty($category->getProducts());
    }
}
