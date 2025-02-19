<?php

namespace App\Services\Discounts;

use App\Models\Order;

class TotalPurchaseDiscount implements DiscountStrategy
{
    private const MIN_AMOUNT = 1000;    // Minimum tutar
    private const DISCOUNT_RATE = 0.10; // İndirim oranı (%10)

    public function calculate(Order $order, float $currentTotal): ?array
    {
        if ($currentTotal >= self::MIN_AMOUNT) {
            $discountAmount = $currentTotal * self::DISCOUNT_RATE;

            return [
                'discountReason' => '10_PERCENT_OVER_1000',
                'discountAmount' => number_format($discountAmount, 2)
            ];
        }

        return null;
    }
}
