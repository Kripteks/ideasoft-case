<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DiscountResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'orderId' => $this->resource['orderId'],
            'discounts' => $this->resource['discounts'],
            'totalDiscount' => $this->resource['totalDiscount'],
            'discountedTotal' => $this->resource['discountedTotal']
        ];
    }
} 