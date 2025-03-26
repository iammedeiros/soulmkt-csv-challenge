<?php
namespace App\Services;

use App\Models\Product;

class ProductResponseMapper {
    public function mapToResponse(array $products): array {
        return array_map(function(Product $product) {
            return [
                'name' => $product->getName(),
                'code' => $product->getCode(),
                'price' => $product->getPrice(),
                'hasNegativePrice' => $product->hasNegativePrice(),
                'hasEvenNumberInCode' => $product->hasEvenNumberInCode()
            ];
        }, $products);
    }
}