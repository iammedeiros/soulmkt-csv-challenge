<?php
namespace App\Models;

class Product {
    private $name;
    private $code;
    private $price;
    
    public function __construct(string $name, string $code, float $price) {
        $this->name = $name;
        $this->code = $code;
        $this->price = $price;
    }
    
    public function getName(): string {
        return $this->name;
    }
    
    public function getCode(): string {
        return $this->code;
    }
    
    public function getPrice(): float {
        return $this->price;
    }
    
    public function hasNegativePrice(): bool {
        return $this->price < 0;
    }
    
    public function hasEvenNumberInCode(): bool {
        return preg_match('/[02468]/', $this->code) === 1;
    }
}