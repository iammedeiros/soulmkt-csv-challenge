<?php
namespace App\Exceptions;

use Exception;

class FileUploadException extends Exception
{
    public const INVALID_FILE_TYPE = 1;
    public const UPLOAD_ERROR = 2;
    public const FILE_NOT_FOUND = 3;
    public const PROCESSING_ERROR = 4;
    
    private const ERROR_MESSAGES = [
        self::INVALID_FILE_TYPE => 'Tipo de arquivo inválido. Apenas arquivos CSV são permitidos.',
        self::UPLOAD_ERROR => 'Erro durante o upload do arquivo. Por favor, tente novamente.',
        self::FILE_NOT_FOUND => 'Arquivo não encontrado no servidor.',
        self::PROCESSING_ERROR => 'Erro ao processar o arquivo.'
    ];
    
    public function __construct(int $code, ?string $customMessage = null)
    {
        $message = $customMessage ?? self::ERROR_MESSAGES[$code] ?? 'Erro desconhecido no upload de arquivo';
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

    public static function fileNotFound(): self
    {
        return new self(self::FILE_NOT_FOUND);
    }
    
    public static function processingError(string $details = ''): self
    {
        $message = self::ERROR_MESSAGES[self::PROCESSING_ERROR];
        if ($details) {
            $message .= " Detalhes: $details";
        }
        return new self(self::PROCESSING_ERROR, $message);
    }
}