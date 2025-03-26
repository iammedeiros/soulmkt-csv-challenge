<?php

use App\Controllers\ProductController;
use App\Services\CsvProcessor;
use App\Services\ProductResponseMapper;

require_once __DIR__ . '/../app/Controllers/ProductController.php';
require_once __DIR__ . '/../app/Services/CsvProcessor.php';
require_once __DIR__ . '/../app/Services/ProductResponseMapper.php';

$csvProcessor = new CsvProcessor(',');
$responseMapper = new ProductResponseMapper();
$productController = new ProductController($csvProcessor, $responseMapper);

$action = $_GET['action'] ?? '';

switch ($action) {
    case 'upload':
        $productController->upload();
        break;
    default:
        include __DIR__ . '/../app/Views/products.php';
}