<?php

namespace App\Http\Controllers\WMCControllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\WMCRequests\RegistrationRequest;
use App\Jobs\WMCAdminRegistrationJob;
use App\Role;
use App\VerifyEmail;
use App\WasteCompany;
use App\WasteCompanyAdmin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    public function register(RegistrationRequest $request)
    {
        DB::transaction(function () use ($request) {

            Role::where('role', 'super_admin')->first();

            $user_details = $request->only(['name', 'email', 'phone']);

            $user_details['password'] = Hash::make($request->password);

            $admin = WasteCompanyAdmin::create($user_details);

            $company_details = $request->except(['name', 'email',
                'phone', 'password']);

            $company = WasteCompany::create($company_details);

            $admin->update(['waste_company_id' => $company->id]);

            if($request->hasFile('logo'))
            {
                $this->uploadCompanyFiles($company, 'loog');
            }

            if($request->hasFile('business_cert'))
            {
                $this->uploadCompanyFiles($company, 'business_cert');
            }

            $new_token = Str::random(60);

            $token = VerifyEmail::create([
                'token' => $new_token,
                'waste_company_admin_id' => $admin->id,
                'isAWMCAdminToken' => true
            ]);

            WMCAdminRegistrationJob::dispatch($admin, $token);

        });

        return response()->json(['status' => 'success'], 200);
    }

    // public function register(Request $request)
    // {
    //     if($this->validator($request->all())->validate())
    //     {
    //         return  $this->create($request->all());
    //     }

    //     return $this->validator($request->all())->validate();
    // }
}
