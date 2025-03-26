# Processador de Arquivos CSV

Aplicação para processamento de arquivos CSV com produtos, incluindo validações e exibição dos resultados em tabela HTML.

## Funcionalidades

- Upload de arquivos CSV com delimitador configurável (vírgula ou ponto e vírgula)
- Validação da estrutura do arquivo (colunas obrigatórias: nome, codigo, preco)
- Ordenação automática dos produtos por nome
- Exibição em tabela HTML com destaque para preços negativos
- Botão para copiar dados em JSON (apenas para produtos com códigos contendo números pares)

## Requisitos

- PHP 8.0+
- Extensão fileinfo habilitada
- Composer (para dependências)
- Docker (para rodar o projeto)

## Instalação

1. Clone o repositório e acesse a pasta do projeto: 
    ```bash
        git clone https://github.com/iammedeiros/soulmkt-csv-challenge.git
        cd soulmkt-csv-challenge

2. Instale as dependências:
    ```bash
    composer install  
    composer dump-autoload  

3. Inicie a aplicação via Docker:
    `docker-compose up -d`

4. Acesse a aplicação no navegador:
    `http://localhost:8000`

5. Rodando os testes:
    `./vendor/bin/phpunit`