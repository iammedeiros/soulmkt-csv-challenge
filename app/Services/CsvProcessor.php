<?php

namespace App\Services;

use App\Models\Product;
use App\Exceptions\FileUploadException;

class CsvProcessor
{
    private $delimiter;

    public function __construct(string $delimiter)
    {
        $this->delimiter = $delimiter;
    }

    public function csvProcess(string $filePath): array
    {
        if (!file_exists($filePath)) {
            throw FileUploadException::fileNotFound();
        }

        $products = [];
        $handle = fopen($filePath, "r");

        if (!$handle) {
            throw FileUploadException::fileOpenError();
        }

        try {
            $headers = fgetcsv($handle, 0, $this->delimiter);
            $columnMap = $this->mapColumns($headers);

            if (empty($columnMap)) {
                throw FileUploadException::columnsNotFound();
            }

            while (($data = fgetcsv($handle, 0, $this->delimiter)) !== FALSE) {
                if ($product = $this->createProduct($data, $columnMap)) {
                    $products[] = $product;
                }
            }

            if (empty($products)) {
                throw FileUploadException::emptyFile();
            }
        } finally {
            fclose($handle);
        }

        usort($products, fn($a, $b) => strcmp($a->getName(), $b->getName()));

        return $products;
    }

    private function mapColumns(array $headers): array
    {
        $map = [];
        foreach ($headers as $index => $header) {
            $header = strtolower(trim($header));

            if (in_array($header, ['nome', 'name']))
                $map['name'] = $index;
            elseif (in_array($header, ['codigo', 'code']))
                $map['code'] = $index;
            elseif (in_array($header, ['preco', 'price']))
                $map['price'] = $index;
        }
        return count($map) === 3 ? $map : [];
    }

    private function createProduct(array $data, array $columnMap): ?Product
    {
        if (empty($columnMap) || max($columnMap) >= count($data)) {
            return null;
        }

        $name = trim($data[$columnMap['name']] ?? '');
        $code = trim($data[$columnMap['code']] ?? '');
        $price = trim(str_replace(['R$', ' '], '', $data[$columnMap['price']]));
        $price = (float) str_replace(',', '.', $price);

        if (empty($name) || empty($code) || $price === 0.0) {
            return null;
        }

        return !empty($name) && !empty($code) ? new Product($name, $code, $price) : null;
    }
}
