<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class WmcAdminResource extends JsonResource
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

            'name' => $this->name,

            'email' => $this->email,

            'phone' => $this->phone,

            'company' => $this->company,

            'role' => $this->role,

            'isActive' => $this->isActive,

            'title' => $this->title,

            'must_change_password' => $this->must_change_password
        ];
    }
}
