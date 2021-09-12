<?php

namespace App\Http\Controllers\UserControllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserFormRequest;
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
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    public function register(UserFormRequest $request)
    {
        DB::beginTransaction();

        try {

            $role = Role::where('role', 'super_admin')->first();

            $user_details = $request->only(['name', 'email', 'phone', 'title', 'location']);

            $user_details['password'] = Hash::make($request->password);

            $user_details['role_id'] = $role->id;

            $admin = User::create($user_details);

            if($request->account_type === 'organization')
            {
                $company_details = $request->except(['name', 'email', 'phone', 'password']);

                $company = Organization::create($company_details);

                $admin->update(['organization_id' => $company->id]);


                Mail::to($company)->queue(new SendCompanyRegistrationMail($admin));

            }else{

                Mail::to($admin)->queue(new SendPersonalRegistrationMail($admin));
            }

        }catch (\Exception $e){

            DB::rollBack();

            Log::info($e->getMessage());

            return response()->json(['message' => 'something went wrong'], 401);
        }
    }

}
