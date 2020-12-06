<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PickUpRequest extends Model
{
    protected $guarded = ['id'];

    public function pickup()
    {
        return $this->belongsTo(PickUp::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }
}
