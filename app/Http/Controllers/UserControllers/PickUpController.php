<?php

namespace App\Http\Controllers\UserControllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserPickupRequest;
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

    public function makePickUpRequest(UserPickupRequest $request)
    {
        $pick_up_request = $request->validated();

        $user = auth()->guard('api')->user();

        if($user->organization)
        {
            $user->organization->addPickupRequest($pick_up_request);
        }else{
            $user->addPickupRequest($pick_up_request);
        }

        return response()->json(['message' => 'request sent']);
    }
}
