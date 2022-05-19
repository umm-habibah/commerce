<?php

namespace App\Tests;

use App\Entity\Category;
use App\Entity\Product;
use PHPUnit\Framework\TestCase;

class ProductTest extends TestCase
{
    public function testIsTrue(): void
    {
        $product = new Product();
        $category = new Category();

        $product->setName('name')
                ->setBrand('brand')
                ->setDescription('description')
                ->setPrice(1234)
                ->setImage('image')
                ->setCategory($category);

        $this->assertTrue($product->getName() === 'name');
        $this->assertTrue($product->getBrand() === 'brand');
        $this->assertTrue($product->getDescription() === 'description');
        $this->assertTrue($product->getPrice() == 1234);
        $this->assertTrue($product->getImage() === 'image');
        $this->assertTrue($product->getCategory() === $category);
    }

    public function testIsFalse(): void
    {
        $product = new Product();
        $category = new Category();

        $product->setName('name')
                ->setBrand('brand')
                ->setDescription('description')
                ->setPrice(1234)
                ->setImage('image')
                ->setCategory($category);

        $this->assertFalse($product->getName() === 'false');
        $this->assertFalse($product->getBrand() === 'false');
        $this->assertFalse($product->getDescription() === 'false');
        $this->assertFalse($product->getPrice() == 123);
        $this->assertFalse($product->getImage() === 'false');
        $this->assertFalse($product->getCategory() === new Category());
    }

    public function testIsEmpty(): void
    {
        $product = new Product();

        $this->assertEmpty($product->getName());
        $this->assertEmpty($product->getBrand());
        $this->assertEmpty($product->getDescription());
        $this->assertEmpty($product->getPrice());
        $this->assertEmpty($product->getImage());
        $this->assertEmpty($product->getCategory());
        $this->assertEmpty($product->getId());
    }
}
