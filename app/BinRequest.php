<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BinRequest extends Model
{
    protected $guarded = ['id'];

    public function organization(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function wasteCompany(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(WasteCompany::class);
    }
}
