<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WasteCompany extends Model
{
    protected $guarded = ['id'];

    public function company()
    {
        return $this->hasMany(WasteCompanyAdmin::class, 'waste_company_id');
    }

    public function pickUpDay()
    {
        return $this->hasMany(PickUp::class);
    }

    public function setPickupDay($pick_up)
    {
        return $this->pickUpDay()->create($pick_up);
    }

    public function pickUpRequest()
    {
        return $this->hasMany(PickUpRequest::class);
    }
}
