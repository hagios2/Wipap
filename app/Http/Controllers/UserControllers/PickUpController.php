<?php

namespace App\Http\Controllers\UserControllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\PickUpResource;
use App\Http\Resources\UserViewPickUpResource;
use App\PickUp;
use App\WasteCompany;
use Illuminate\Http\Request;

class PickUpController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }


    public function viewPickUp()
    {
        #todo
        #find out which company picks up for every zone

        $wm_company = WasteCompany::query()->where([['published', true] , ['status', 'active']])->latest()->first();

        if($wm_company)
        {
            $pick_ups = PickUp::query()->where('waste_company_id', $wm_company->id)->get();

            return UserViewPickUpResource::collection($pick_ups);
        }else{
            return response()->json(['message' => 'services turned off']);
        }
    }

    public function makePickUpRequest(PickUp $pickUp)
    {
        $user = auth()->guard('api')->user();

        if($user->organization)
        {
            $pickUp->addPickupRequest(['organization_id' => $user->organization->id]);
        }else{

            $pickUp->addPickupRequest(['user_id' => $user->id]);
        }

        return response()->json(['message' => 'request sent']);

    }
}
