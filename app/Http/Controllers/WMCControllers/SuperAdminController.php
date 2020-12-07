<?php

namespace App\Http\Controllers\WMCControllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\NewWMCAdminRequest;
use App\Http\Resources\ViewWMCAdminsResource;
use App\Jobs\NewWMCAdminJob;
use App\Role;
use App\WasteCompanyAdmin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class SuperAdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('isSuperAdmin');
    }

    public function fetchAdmins()
    {
       $role = Role::query()->where('role', 'super_admin')->first();

        $admins = WasteCompanyAdmin::where('role_id', '!=', $role->id)->get();

        return ViewWMCAdminsResource::collection($admins);
    }

    public function newAdmin(NewWMCAdminRequest $request)
    {
        $attributes = $request->validated();

        $password = Str::random(8);

        $attributes['password'] = Hash::make($password);

        $attributes['must_change_password'] = true;

        $attributes['waste_company_id'] = auth()->guard('wmc_admin')->user()->waste_company_id;

        $admin = WasteCompanyAdmin::create($attributes);

        NewWMCAdminJob::dispatch($admin, $password);

        return response()->json(['status' => 'new admin added']);
    }



    public function blockAdmin(WasteCompanyAdmin $admin)
    {

        $admin->update(['isActive' => false]);

        return response()->json(['status' => 'blocked']);

    }


    public function unblockAdmin(WasteCompanyAdmin $admin)
    {

        $admin->update(['isActive' => true]);

        return response()->json(['status' => 'unblocked']);
    }


    public function publishCompany()
    {

        if(auth()->guard('wmc_admin')->user()->company->published)
        {
            return response()->json(['status' => 'Company is live already']);
        }

        auth()->guard('wmc_admin')->user()->company->update(['published' => true ]);

        return response()->json(['status' => 'Turned services on']);

    }

    public function unPublishCompany()
    {

        if(auth()->guard('wmc_admin')->user()->company->published)
        {
            auth()->guard('wmc_admin')->user()->company->update(['published' => false ]);

            return response()->json(['status' => 'Turned services off']);
        }

        return response()->json(['status' => 'Services are already off']);

    }


}
