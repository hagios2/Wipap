<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;


/**
 * @method static create(array $user_details)
 * @method static where(string $string, mixed $email)
 */
class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

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


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];



    public function organization(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    public function binRequest(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(BinRequest::class);
    }

    public function makeABinRequest($bin_request): \Illuminate\Database\Eloquent\Model
    {
        return $this->binRequest()->create($bin_request);
    }

    public function role(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    public function addPickupRequest($pickup): \Illuminate\Database\Eloquent\Model
    {
        return $this->pickupRequest()->create($pickup);
    }

    public function pickupRequest(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(PickUpRequest::class);
    }

    public function billingDetail(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(BillingDetail::class);
    }

    public function addBillingDetail($billing_detail): \Illuminate\Database\Eloquent\Model
    {
        return $this->billingDetail()->create($billing_detail);
    }
}
