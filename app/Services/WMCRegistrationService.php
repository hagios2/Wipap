<?php

namespace App\Services;

use App\BinRequest;
use App\Http\Requests\WMCRequests\RegistrationRequest;
use App\Http\Resources\BinRequestResource;
use App\Jobs\WMCAdminRegistrationJob;
use App\Role;
use App\VerifyEmail;
use App\WasteCompany;
use App\WasteCompanyAdmin;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class WMCRegistrationService extends UploadServices
{
    public function addNewWMC(RegistrationRequest $request): \Illuminate\Http\JsonResponse
    {
        DB::beginTransaction();

        try {

            $role = Role::where('role', 'super_admin')->first();

            $user_details = $request->only(['name', 'email', 'phone', 'title']);

            $user_details['password'] = Hash::make($request->password);

            $user_details['role_id'] = $role->id;

            $admin = WasteCompanyAdmin::create($user_details);

            $company_details = $request->except(['name', 'email',
                'phone', 'password', 'title']);

            $company_details['status'] = 'active';

            $company = WasteCompany::create($company_details);

            $admin->update(['waste_company_id' => $company->id]);

            if($request->hasFile('logo'))
            {
                $this->uploadCompanyFiles($company, 'logo');
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

            DB::commit();

            return response()->json(['status' => 'success'],201);

        }catch (\Exception $e){

            DB::rollBack();

            Log::info($e->getMessage());

            return response()->json(['message' => 'something went wrong'], 401);
        }
    }
}
