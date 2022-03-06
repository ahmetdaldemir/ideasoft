<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderDiscountResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'orderId' => $this->orderId,
            'discounts' => $this->discounts,
            'totalDiscount' => $this->totalDiscount,
            'discountedTotal' => $this->discountedTotal,
            'created_at' => $this->created_at->format('d-m-Y'),
            'updated_at' => $this->updated_at->format('d-m-Y'),
        ];
    }
}
