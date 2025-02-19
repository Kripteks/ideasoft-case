<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\DiscountResource;
use App\Services\DiscountService;
use Illuminate\Http\JsonResponse;

class DiscountController extends Controller
{
    protected $discountService;

    public function __construct(DiscountService $discountService)
    {
        $this->discountService = $discountService;
    }

    /**
     * Sipariş için indirimleri hesaplar
     */
    public function calculateDiscount(int $id): JsonResponse
    {
        return response()->json(
            new DiscountResource($this->discountService->calculateDiscount($id))
        );
    }
}
