<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WasteCompany extends Model
{
    protected $guarded = ['id'];

    public function company()
    {
        return $this->hasMany(WasteCompanyAdmin::class);
    }
}
