<?php

namespace App\Http\Resources;

use App\Models\Airport;
use Illuminate\Http\Resources\Json\JsonResource;

class FlightResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => "{$this->from->airport} - {$this->to->airport}",
            'from' => AirportResource::make($this->from),
            'city' => AirportResource::make($this->to),
            'cost' => $this->cost * $request->passengers
        ];
    }
}
