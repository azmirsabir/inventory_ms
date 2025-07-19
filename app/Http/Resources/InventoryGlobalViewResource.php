<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InventoryGlobalViewResource extends JsonResource
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
        'product_name' => $this->product->name ?? '',
        'total_quantity' => $this->total_quantity ?? 0,];
    }
}
