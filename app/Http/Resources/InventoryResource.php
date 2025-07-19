<?php

namespace App\Http\Resources;

use App\Models\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InventoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
      return [
        'id' => $this->id,
        'product_id' => $this->product_id,
        'product' => ProductResource::collection($this->whenLoaded('product')),
        'warehouse_id' => $this->warehouse_id,
        'warehouse' => new WarehouseResource($this->whenLoaded('warehouse')),
        'quantity' => $this->quantity,
        'minimum_quantity' => $this->minimum_quantity,
        'created_at' => $this->created_at,
        'updated_at'       => $this->updated_at,
      ];
    }
}
