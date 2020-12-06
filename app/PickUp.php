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
}
