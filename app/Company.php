<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use SMartins\PassportMultiauth\HasMultiAuthApiTokens;

class Company extends Authenticatable
{
    use Notifiable, HasMultiAuthApiTokens;
/* 
    protected $hidden = ['password']; */

    protected $fillable = [
        'company_name', 'email', 'password', 'phone', 'last_login', 'status', 'location'
    ];

    public function findForPassport($username)
    {
        $user = $this->where([['email', $username], ['status', 'active']])->first();

        if($user)
        {
            $user->update(['last_login' => now()]);

            return $user;
        }

        return $user;
    }

}
