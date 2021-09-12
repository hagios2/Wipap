<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static create(array $company_details)
 */
class Organization extends Model
{
    protected $guarded = ['id'];

    public function addPickupRequest($pickup): Model
    {
        return $this->pickupRequest()->create($pickup);
    }

    public function pickupRequest(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(PickUpRequest::class);
    }

    public function binRequest(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(BinRequest::class);
    }

    public function makeABinRequest($bin_request): \Illuminate\Database\Eloquent\Model
    {
        return $this->binRequest()->create($bin_request);
    }
}
