<?php

namespace Tests\Unit;

use App\Models\Product;
use PHPUnit\Framework\TestCase;

class ProductTest extends TestCase
{
    public function testProductCreation()
    {
        $product = new Product('Produto A', 'COD123', 19.99);

        $this->assertEquals('Produto A', $product->getName());
        $this->assertEquals('COD123', $product->getCode());
        $this->assertEquals(19.99, $product->getPrice());
    }

    public function testHasNegativePrice()
    {
        $product1 = new Product('Produto A', 'COD123', -5.00);
        $product2 = new Product('Produto B', 'COD456', 10.00);

        $this->assertTrue($product1->hasNegativePrice());
        $this->assertFalse($product2->hasNegativePrice());
    }

    public function testHasEvenNumberInCode()
    {
        $testCases = [
            ['code' => 'COD123', 'expected' => true],  
            ['code' => 'COD135', 'expected' => false], 
            ['code' => 'CO246D', 'expected' => true],  
            ['code' => 'ABCDE', 'expected' => false],  
            ['code' => '13579', 'expected' => false],  
            ['code' => '02468', 'expected' => true],   
            ['code' => 'PAR1', 'expected' => false],   
            ['code' => 'PAR2', 'expected' => true]     
        ];

        foreach ($testCases as $case) {
            $product = new Product('Test', $case['code'], 10.00);
            $this->assertEquals($case['expected'], $product->hasEvenNumberInCode());
        }
    }
}
