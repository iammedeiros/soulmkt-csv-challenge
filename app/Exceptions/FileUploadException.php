<?php
namespace App\Exceptions;

use Exception;

class FileUploadException extends Exception
{
    public const INVALID_FILE_TYPE = 1;
    public const UPLOAD_ERROR = 2;
    public const EMPTY_FILE = 3;
    public const COLUMNS_NOT_FOUND = 4;
    public const FILE_OPEN_ERROR = 5;
    public const FILE_NOT_FOUND = 6;
    
    private const ERROR_MESSAGES = [
        self::INVALID_FILE_TYPE => 'Tipo de arquivo inválido. Apenas arquivos CSV são permitidos.',
        self::UPLOAD_ERROR => 'Erro durante o upload do arquivo. Por favor, tente novamente.',
        self::EMPTY_FILE => 'Não foi possível realizar o processamento. O arquivo CSV está vazio ou os dados são inválidos.',
        self::COLUMNS_NOT_FOUND => 'As colunas obrigatórias (nome, codigo, preco) não foram encontradas no arquivo CSV ou o delimitador foi informado incorretamente.',
        self::FILE_OPEN_ERROR => 'Não foi possível abrir o arquivo para leitura.',
        self::FILE_NOT_FOUND => 'O arquivo especificado não foi encontrado no servidor.'
    ];
    
    public function __construct(int $code, ?string $customMessage = null)
    {
        $message = $customMessage ?? self::ERROR_MESSAGES[$code] ?? 'Erro desconhecido no upload do arquivo';
        parent::__construct($message, $code);
    }

    public static function invalidFileType(): self
    {
        return new self(self::INVALID_FILE_TYPE);
    }
    
    public static function uploadError(): self
    {
        return new self(self::UPLOAD_ERROR);
    }

    public static function emptyFile(): self
    {
        return new self(self::EMPTY_FILE);
    }
    
    public static function columnsNotFound(): self
    {
        return new self(self::COLUMNS_NOT_FOUND);
    }
    
    public static function fileOpenError(): self
    {
        return new self(self::FILE_OPEN_ERROR);
    }
    
    public static function fileNotFound(): self
    {
        return new self(self::FILE_NOT_FOUND);
    }
}