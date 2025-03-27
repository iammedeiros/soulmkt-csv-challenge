<?php

namespace Tests\Unit;

use App\Services\CsvProcessor;
use PHPUnit\Framework\TestCase;

class CsvProcessorTest extends TestCase
{
    public function testCsvProcessIgnoresIncompleteRows()
    {
        // Criação de um arquivo CSV de teste
        $filePath = __DIR__ . '/test2.csv';
        file_put_contents($filePath, "descricao,codigo,nome,estoque,categoria,preco\n"
                                      . "Produto incrível,123,Produto A,50,Eletrônicos,R$ 10,00\n"
                                      . "Outro ótimo produto,456,Produto B,20,Roupas,\n"
                                      . "Produto X,789,Produto C,30,Brinquedos,R$ 15,50\n");
        $csvProcessor = new CsvProcessor(',');

        $products = $csvProcessor->csvProcess($filePath);

        $this->assertCount(2, $products);

        unlink($filePath);
    }
}