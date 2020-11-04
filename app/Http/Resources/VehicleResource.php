<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class VehicleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [

            'id' => $this->id,
            'vehicle_no' => $this->vehicle_no,
            'gps_module' => $this->gps_module,
            'garbage_type' => $this->garbage_type

        ];
    }
}
