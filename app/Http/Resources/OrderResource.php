<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id'           => $this->id,
            'customerId'   => $this->customerId,
            'items'        => $this->items,
            'total'        => $this->total,
            'created_at'   => $this->created_at->format('d-m-Y'),
            'updated_at'   => $this->updated_at->format('d-m-Y'),
        ];
    }
}
