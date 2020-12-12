<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    protected $guarded = ['id'];

    public function addPickupRequest($pickup)
    {
        return $this->pickupRequest()->create($pickup);
    }

    public function pickupRequest()
    {
        return $this->hasMany(PickUpRequest::class);
    }
}
