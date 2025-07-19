<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AuthResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
      return [
        'api_token' => $this->api_token ?? null,
        'refresh_token' => $this->refresh_token ?? null,
        'expires_in' => $this->expires_in ?? null,
        'user' => new UserResource($this->resource),
      ];
    }
}
