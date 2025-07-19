<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LowStockResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
          'product_id' => $this->product_id,
          'SKU' => $this->product->sku ?? '',
          'current_quantity' => $this->quantity ?? 0,
          'minimum_quantity' => $this->minimum_quantity ?? 0,
          'warehouse_location' => $this->warehouse->location ?? '',
          'country' => $this->warehouse->country->name ?? '',
        ];
    }
}
