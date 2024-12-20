<?php

namespace App\Http\Resources\API;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TenantResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'         => $this->id,
            'name'       => $this->name,
            'email'      => $this->email,
            'avatar'     => $this->avatar,
            'website'    => $this->website,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'vehicles'   => VehicleResource::collection($this->vehicles),
        ];
    }
}
