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

class SuperAdminController extends Controller
{

    public function fetchAdmins()
    {
        $role = Role::query()->where('role', 'super_admin')->get();

        $admins = WasteCompanyAdmin::where('role_id', '!=', $role->id)->get();

        return ViewWMCAdminsResource ::collection($admins);
    }

    public function newAdmin(NewWMCAdminRequest $request)
    {

        if(auth()->guard('wmc_admin')->user()->role->role == 'super_admin')
        {

            $attributes = $request->validated();

            $password = Str::random(8);

            $attributes['password'] = Hash::make($password);

            $attributes['must_change_password'] = true;

            $attributes['waste_company_id'] = auth()->guard('wmc_admin')->user();

            $admin = WasteCompanyAdmin::create($attributes);

            NewWMCAdminJob::dispatch($admin, $password);

            return response()->json(['status' => 'new admin added']);
        }

        return response()->json(['message' => 'Forbidden'], 403);

    }



    public function blockUser(WasteCompanyAdmin $user)
    {

        $user->update(['isActive' => false]);

        return response()->json(['status' => 'blocked']);

    }


    public function unblockUser(WasteCompanyAdmin $user)
    {

        $user->update(['isActive' => true]);

        return response()->json(['status' => 'unblocked']);

    }


}
