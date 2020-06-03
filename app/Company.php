<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use SMartins\PassportMultiauth\HasMultiAuthApiTokens;

class Company extends Model
{
    use Notifiable, HasMultiAuthApiTokens;

    protected $guard = 'company';

    protected $guarded = ['id'];

    protected $hidden = ['password'];



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
