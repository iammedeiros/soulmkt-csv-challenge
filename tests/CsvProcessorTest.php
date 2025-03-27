<?php

namespace Tests\Unit;

use App\Services\CsvProcessor;
use PHPUnit\Framework\TestCase;
use App\Exceptions\FileUploadException;


class CsvProcessorTest extends TestCase
{
    public function testCsvProcessIgnoresIncompleteRows()
    {
        $filePath = __DIR__ . '/test2.csv';
        file_put_contents($filePath, "codigo,nome,preco\n"
            . "123,Produto A,R$ 10,00\n"
            . "456,Produto B,\n"
            . "789,Produto C,R$ 15,50\n");
        $csvProcessor = new CsvProcessor(',');

        $products = $csvProcessor->csvProcess($filePath);

        $this->assertCount(2, $products);

        unlink($filePath);
    }

    public function testCsvProcessThrowsExceptionWhenRequiredColumnIsMissing()
    {
        //CSV de teste com a coluna 'preco' faltando
        $filePath = __DIR__ . '/test_missing_price.csv';
        file_put_contents($filePath, "codigo,nome\n"
            . "123,Produto A\n"
            . "456,Produto B\n"
            . "789,Produto C\n");

        $this->expectException(FileUploadException::class);
        $this->expectExceptionMessage('As colunas obrigatórias (nome, codigo, preco) não foram encontradas no arquivo CSV ou o delimitador foi informado incorretamente.');

        $csvProcessor = new CsvProcessor(',');
        $csvProcessor->csvProcess($filePath);

        unlink($filePath);
    }
}
