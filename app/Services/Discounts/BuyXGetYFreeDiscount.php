<?php

namespace App\Services\Discounts;

use App\Models\Order;

class BuyXGetYFreeDiscount implements DiscountStrategy
{
    private const CATEGORY_ID = 2;  // Hedef kategori
    private const BUY_QUANTITY = 6; // Kaç adet alınması gerekiyor
    private const FREE_QUANTITY = 1; // Kaç adet bedava

    public function calculate(Order $order, float $currentTotal): ?array
    {
        $categoryItems = $order->items()->whereHas('product', function ($query) {
            $query->where('category', self::CATEGORY_ID);
        })->with('product')->get();

        foreach ($categoryItems as $item) {
            if ($item->quantity >= self::BUY_QUANTITY) {
                // Kaç adet bedava ürün kazanıldı
                $freeItems = (int)($item->quantity / self::BUY_QUANTITY);

                // Bedava ürünlerin toplam tutarı
                $discountAmount = $item->unit_price * $freeItems;

                return [
                    'discountReason' => 'BUY_5_GET_1',
                    'discountAmount' => number_format($discountAmount, 2)
                ];
            }
        }

        return null;
    }
}
