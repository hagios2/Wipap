<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserViewPickUpResource extends JsonResource
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

            'pick_up_date' => $this->pick_up_date,

            'waste_company' => [
                'id' => $this->wasteCompany->id,
                'company_name' => $this->wasteCompany->company_name
            ],

            'garbage_type' => $this->garbageType
        ];
    }
}
