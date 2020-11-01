<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BinRequest extends Model
{
    protected $guarded = ['id'];

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    public function client()
    {
        return $this->belongsTo(User::class);
    }

    public function wasteCompany()
    {
        return $this->belongsTo(WasteCompany::class);
    }
}
