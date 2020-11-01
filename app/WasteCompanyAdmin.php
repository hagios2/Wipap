<?php

namespace App;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * @method static create(array $attributes)
 * @method static where(string $string, string $string1, \Illuminate\Support\HigherOrderCollectionProxy $id)
 */
class WasteCompanyAdmin extends Authenticatable implements JWTSubject
{
    use Notifiable;

    protected $guarded = ['id'];

    // Rest omitted for brevity

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function company()
    {
        return $this->belongsTo(WasteCompany::class, 'waste_company_id');
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

}
