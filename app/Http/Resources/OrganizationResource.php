<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrganizationResource extends JsonResource
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

            'company_name' => $this->company_name,

            'email' => $this->email,

            'phone' => $this->phone,

            'location' => $this->location,

            'status' => $this->status,

            'logo' => $this->status,
        ];
    }
}
