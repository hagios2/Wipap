<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    protected $guarded = ['id'];

    public function garbageType()
    {
        return $this->belongsTo(GarbageType::class);
    }
}
