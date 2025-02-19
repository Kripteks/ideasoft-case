<?php

namespace App\Services\Discounts;

use App\Models\Order;

interface DiscountStrategy
{
    /**
     * İndirim hesaplama
     * 
     * @param Order $order Sipariş
     * @param float $currentTotal Mevcut toplam (önceki indirimler düşülmüş)
     * @return array|null İndirim bilgisi veya boş array
     */
    public function calculate(Order $order, float $currentTotal): ?array;
} 