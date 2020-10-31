<?php

namespace App\Http\Controllers\WMCControllers;

use App\Role;
use App\VerifyEmail;
use App\WasteCompany;
use App\WasteCompanyAdmin;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Jobs\WMCAdminRegistrationJob;
use App\Http\Requests\WMCRequests\RegistrationRequest;

class WMCAdminRegistrationController extends Controller
{
    public function create(RegistrationRequest $request)
    {
        DB::transaction(function () use ($request) {

            Role::where('role', 'super_admin')->first();

            $user_details = $request->only(['name', 'email',
            'phone']);
    
            $user_details['password'] = Hash::make($request->password);
    
            $admin = WasteCompanyAdmin::create($user_details);

            $company_details = $request->only(['name', 'email',
            'phone']);

            $merchandiser = WasteCompany::create($company_details);

            $new_token = Str::random(60);
            
            $token = VerifyEmail::create([
                'token' => $new_token,
                'waste_company_admin_id' => $admin->id,
                'isAWMCAdminToken' => true
            ]);

            WMCAdminRegistrationJob::dispatch($merchandiser, $token);
       
            return response()->json(['status' => 'success'], 200);
            
        }); 
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