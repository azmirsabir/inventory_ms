<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WarehouseResource extends JsonResource
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
        'location' => $this->location,
        'country_id' => $this->country_id,
        'country' => new CountryResource($this->whenLoaded('country')),
        'created_at' => $this->created_at,
        'updated_at' => $this->updated_at,
      ];
    }
}
