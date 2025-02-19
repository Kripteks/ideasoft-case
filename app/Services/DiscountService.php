<?php

namespace App\Services;

use App\Models\Order;
use App\Services\Discounts\DiscountStrategy;
use App\Services\Discounts\BuyXGetYFreeDiscount;
use App\Services\Discounts\TotalPurchaseDiscount;
use App\Services\Discounts\CategoryMultiItemDiscount;

class DiscountService
{
    /**
     * @var DiscountStrategy[]
     */
    private array $discountStrategies;

    public function __construct()
    {
        $this->discountStrategies = [
            new BuyXGetYFreeDiscount(),      // Önce "6 al 1 bedava" indirimi
            new TotalPurchaseDiscount(),      // Sonra toplam tutar indirimi
            new CategoryMultiItemDiscount(),  // En son kategori bazlı indirim
        ];
    }

    /**
     * Sipariş için tüm indirimleri hesaplar
     *
     * @param Order $order
     * @return array
     */
    public function calculateDiscount(int $order_id): array
    {
        $order = Order::find($order_id);

        if (!$order) {
            throw new \Exception('Sipariş bulunamadı');
        }

        $discounts = [];
        $totalDiscount = 0;
        $subtotal = $order->total;


        foreach ($this->discountStrategies as $strategy) {
            $discount = $strategy->calculate($order, $subtotal);

            if (!empty($discount)) {
                // İndirim tutarını subtotal'dan düş
                $subtotal -= (float)$discount['discountAmount'];
                $discount['subtotal'] = number_format($subtotal, 2);

                // İndirimi listeye ekle
                $discounts[] = $discount;
                $totalDiscount += (float)$discount['discountAmount'];
            }
        }

        return [
            'orderId' => $order->order_id,
            'discounts' => $discounts,
            'totalDiscount' => number_format($totalDiscount, 2),
            'discountedTotal' => number_format($subtotal, 2)
        ];
    }
}
