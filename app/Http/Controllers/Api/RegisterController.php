<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Jobs\CompanyRegistrationJob;
use App\Jobs\UserRegistrationJob;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserFormRequest;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\Company;

class RegisterController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->only('update');
    }

    public function register(UserFormRequest $request)
    {
        if($request->account_type == 'personal')
        {
            $user = User::create([

                'name' => $request->name,
                'email' => $request->email,
                'location' => $request->location,
                'phone'=> $request->phone,
                'status' => 'active',
                'password' => Hash::make($request['password']),
    
            ]);

            UserRegistrationJob::dispatch($user);

            return response()->json(['status' => 'success']);

        }else if($request->account_type == 'company'){

           $company =  Company::create([

                'company_name' => $request->company_name,
                'email' => $request->email,
                'location' => $request->location,
                'phone'=> $request->phone,
                'status' => 'active',
                'password' => Hash::make($request['password']),
            ]);

            CompanyRegistrationJob::dispatch($company);

            return response()->json(['status' => 'success']);

        }
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
