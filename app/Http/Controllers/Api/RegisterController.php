<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserFormRequest;
use Illuminate\Support\Facades\Hash;
use App\User;

class RegisterController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->only('update');
    }

    public function register(UserFormRequest $request)
    {
        $user = User::create([

            'name' => $request['name'],
            'email' => $request['email'],
            'phone'=> $request['phone'],
            'password' => Hash::make($request['password']),

        ]);

        if($user):

            return response()->json(['status' => 'success']);
        
        else: 
            
            return response()->json(['status' => 'failed']);

        
        endif;
    }


    public function update(Request $request)
    {
        $attribute = $request->validate([

            "name" => 'required|string',

            "email" => "required|email",

            "phone" => "required|string",

        ]);

        auth()->guard('api')->user()->update($attribute);


        return response()->json(['status' => 'success']);

    }



    public function logoutApi()
    {
        $user = auth()->guard('api')->user()->token();
    
        $user->revoke();
    
        return response()->json(['status' => 'logged out']);
    }


    
}
