<?php

namespace App\Tests\Unit\Model;

use App\Model\Product;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class ProductTest extends TestCase
{

    /*
Test de
1 Savoir si le nom est correspond à la meme valeur
2 Il ne doit pas être Null
3 Respect les Bool est true

*/

    public function getModel(): Product
    {
        return new Product('kevin', 3, 'general', false);
    }


    #[Test]
    public function entity()
    {

        $product = $this->getModel();
        $this->assertInstanceOf(Product::class, $product);
    }


    #[Test]
    public function allName()
    {
        $product = $this->getModel();
        $this->assertNotNull($product->getName());
        $this->assertEquals('kevin', $product->getName());
        $this->assertEquals(5, strlen($product->getName()));
    }

    #[Test]
    public function prixFloat(): void
    {
        $product = $this->getModel();
        $this->assertIsFloat($product->getPrice());
    }

    #[Test]
    public function inStockFalse(): void
    {
        $product = $this->getModel();
        $status = $product->getInStock();

        $this->assertFalse($status);
    }

    #[Test]
    public function nameouCategory(): void
    {
        $product = $this->getModel();
        $nameProduct = $product->getName();
        $category = $product->getCategory();

        $this->assertIsString($nameProduct, 'le nom est pas ');
        $this->assertIsString($category);
    }
}
