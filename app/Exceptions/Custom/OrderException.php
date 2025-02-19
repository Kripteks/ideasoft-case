<?php

namespace App\Exceptions\Custom;

use Exception;

class OrderException extends Exception
{
    protected $errorType;

    public function __construct(string $message, string $errorType, int $code = 400)
    {
        parent::__construct($message, $code);
        $this->errorType = $errorType;
    }

    public function getErrorType(): string
    {
        return $this->errorType;
    }

    public static function outOfStock(string $productName, int $availableStock, int $requestedQuantity): self
    {
        return new self(
            "Ürün '{$productName}' için yeterli stok bulunmamaktadır. Mevcut stok: {$availableStock}, İstenen miktar: {$requestedQuantity}",
            'OUT_OF_STOCK',
            400
        );
    }

    public static function invalidOrder(string $reason): self
    {
        return new self(
            "Sipariş oluşturulamadı: {$reason}",
            'INVALID_ORDER',
            400
        );
    }
} 