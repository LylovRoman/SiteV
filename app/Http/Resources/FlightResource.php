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
            'to' => AirportResource::make($this->to),
            'start_date' => [
                'date' => $this->from_date,
                'time' => $this->time_from
            ],
            'end_date' => [
                'date' => $this->to_date,
                'time' => $this->time_to
            ],
            'cost' => $this->cost * $request->passengers
        ];
    }
}
