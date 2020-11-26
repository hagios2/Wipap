<?php

namespace App\Http\Controllers\UserControllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\WMCRequests\RegistrationRequest;
use App\Jobs\WMCAdminRegistrationJob;
use App\Mail\SendCompanyRegistrationMail;
use App\Mail\SendPersonalRegistrationMail;
use App\Organization;
use App\Role;
use App\User;
use App\VerifyEmail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    public function register(RegistrationRequest $request)
    {
        DB::transaction(function () use ($request) {

            $role = Role::where('role', 'super_admin')->first();

            $user_details = $request->only(['name', 'email', 'phone']);

            $user_details['password'] = Hash::make($request->password);

            $user_details['role_id'] = $role->id;

            $admin = User::create($user_details);

            if($request->has('organization'))
            {
                $company_details = $request->except(['company_name', 'email',
                    'phone', 'location', 'status']);

                $company = Organization::create($company_details);

                $admin->update(['organization_id' => $company->id]);

//                if($request->hasFile('logo'))
//                {
//                    $this->uploadCompanyFiles($company, 'logo');
//                }

                Mail::to($company)->queue(new SendCompanyRegistrationMail($admin));

            }else{

                Mail::to($admin)->queue(new SendPersonalRegistrationMail($admin));
            }

//            $new_token = Str::random(60);

//            $token = VerifyEmail::create([
//                'token' => $new_token,
//                'waste_company_admin_id' => $admin->id,
//                'isAWMCAdminToken' => true
//            ]);



        });

        return response()->json(['status' => 'success'], 200);
    }

}
