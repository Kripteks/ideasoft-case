<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Exceptions\Custom\OrderException;
use App\Http\Resources\OrderResource;
use App\Http\Resources\OrderCollection;

class OrderService
{
    public function getAllOrders()
    {
        $orders = Order::with(['customer', 'items.product'])->get();
        return new OrderCollection($orders);
    }

    public function getOrder(Order $order)
    {
        return new OrderResource($order->load(['customer', 'items.product']));
    }

    public function createOrder(array $data)
    {
        // Önce stok kontrolü yapalım
        foreach ($data['items'] as $item) {
            $product = Product::find($item['product_id']);
            if (!$product) {
                throw OrderException::invalidOrder("Ürün bulunamadı: {$item['product_id']}");
            }

            if ($product->stock < $item['quantity']) {
                throw OrderException::outOfStock(
                    $product->name,
                    $product->stock,
                    $item['quantity']
                );
            }
        }

        // Stok yeterliyse siparişi oluşturalım
        $total = 0;
        $orderItems = [];

        foreach ($data['items'] as $item) {
            $product = Product::find($item['product_id']);
            $itemTotal = $product->price * $item['quantity'];
            $total += $itemTotal;

            $orderItems[] = [
                'product_id' => $product->id,
                'quantity' => $item['quantity'],
                'unit_price' => $product->price,
                'total' => $itemTotal
            ];

            // Stok güncelleme
            $product->decrement('stock', $item['quantity']);
        }

        $order = Order::create([
            'customer_id' => $data['customer_id'],
            'total' => $total
        ]);

        $order->items()->createMany($orderItems);

        return new OrderResource($order->load(['customer', 'items.product']));
    }

    public function deleteOrder(Order $order)
    {

        foreach ($order->items as $item) {
            $item->product->increment('stock', $item->quantity); // Stokları geri yüklemek istersek bu methodu kullanabiliriz
        }

        OrderItem::where('order_id', $order->order_id)->delete();

        $order->delete();
        return true;
    }
}
