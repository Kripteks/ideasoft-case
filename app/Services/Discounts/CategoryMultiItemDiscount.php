<?php

namespace App\Services\Discounts;

use App\Models\Order;

class CategoryMultiItemDiscount implements DiscountStrategy
{
    private const CATEGORY_ID = 1;       // Hedef kategori
    private const MIN_ITEMS = 2;         // Minimum ürün sayısı
    private const DISCOUNT_RATE = 0.20;  // İndirim oranı (%20)

    public function calculate(Order $order, float $currentTotal): ?array
    {
        $categoryItems = $order->items()->whereHas('product', function ($query) {
            $query->where('category', self::CATEGORY_ID);
        })->with('product')->get();

        if ($categoryItems->count() >= self::MIN_ITEMS) {

            $cheapestItem = $categoryItems->sortBy('unit_price')->first();

            // En ucuz ürüne indirim uygula
            $discountAmount = $cheapestItem->unit_price * self::DISCOUNT_RATE;

            return [
                'discountReason' => 'CHEAPEST_ITEM_20_PERCENT',
                'discountAmount' => number_format($discountAmount, 2)
            ];
        }

        return null;
    }
}
