<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
          'name' => $this->name,
          'sku' => $this->sku,
          'status' => $this->status,
          'description' => $this->description,
          'price' => $this->price,
          'created_at' => $this->created_at,
          'updated_at' => $this->updated_at,
        ];
    }
}
