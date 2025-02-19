<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOrderRequest;
use App\Models\Order;
use App\Services\OrderService;
use Illuminate\Http\JsonResponse;

class OrderController extends Controller
{
    protected $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function index(): JsonResponse
    {
        return response()->json(
            $this->orderService->getAllOrders()
        );
    }

    public function store(StoreOrderRequest $request): JsonResponse
    {
        return response()->json(
            $this->orderService->createOrder($request->validated())
        );
    }

    public function show(int $id): JsonResponse
    {
        $order = Order::find($id);

        if (!$order){
            return response()->json([
                'message' => 'Sipariş bulunamadı'
            ], 404);
        }

        return response()->json(
            $this->orderService->getOrder($order)
        );
    }

    public function destroy(int $id): JsonResponse
    {
        $order = Order::find($id);

        if (!$order){
            return response()->json([
                'message' => 'Sipariş bulunamadı'
            ], 404);
        }

        $this->orderService->deleteOrder($order);
        return response()->json([
            'message' => 'Silme işlemi başarılı'
        ], 204);
    }
}
