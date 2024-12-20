<?php

namespace App\Http\Resources\API;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VehicleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'             => $this->id,
            'name'           => $this->name,
            'plate_number'   => $this->plate_number,
            'color'          => $this->color,
            'type'           => $this->type,
            'brand'          => $this->brand->name,
            'model'          => $this->model,
            'year'           => $this->year,
            'purchase_value' => $this->purchase_value,
            'attachments'    => $this->attachments,
            'status'         => $this->status,
            'created_at'     => $this->created_at,
            'tenant'         => $this->tenant,
        ];
    }
}
