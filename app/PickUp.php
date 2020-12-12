<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PickUp extends Model
{
    protected $guarded = ['id'];

    public function day()
    {
        return $this->belongsTo(Day::class);
    }

    public function wasteCompany()
    {
        return $this->belongsTo(WasteCompany::class);
    }

    public function garbageType()
    {
        return $this->belongsTo(GarbageType::class);
    }

    public function scopeWasteCompany($query)
    {
        return $query->where('waste_company_id',auth()->guard('wmc_admin')->user()->company->id);
    }
}
