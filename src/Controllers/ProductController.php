<?php
namespace App\Controllers;

use App\Services\CsvProcessor;
use App\Services\ProductResponseMapper;
use App\Exceptions\FileUploadException;

class ProductController {
    private $csvProcessor;
    private $responseMapper;
    
    public function __construct(CsvProcessor $csvProcessor, ProductResponseMapper $responseMapper) {
        $this->csvProcessor = $csvProcessor;
        $this->responseMapper = $responseMapper;
    }
    
    private function validateUpload(): void {
        if (!isset($_FILES['csv_file']) || $_FILES['csv_file']['error'] !== UPLOAD_ERR_OK) {
            throw new FileUploadException('Erro no upload do arquivo');
        }
        
        if ($_FILES['csv_file']['type'] !== 'text/csv') {
            throw new FileUploadException('Apenas arquivos CSV são permitidos');
        }
    }
}