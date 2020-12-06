<?php

namespace App\Http\Controllers\WMCControllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\PickUpRequestResource;
use App\Http\Resources\PickUpResource;
use App\PickUp;
use App\PickUpRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PickupController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:wmc_admin');
    }

    public function setPickupDays(Request $request)
    {
        auth()->guard('wmc_admin')->user()->company->setPickupDay($request->validate(['day_id' => 'required|integer']));

        return response()->json(['message' => 'saved']);
    }

    public function destroy(PickUp $pickUp)
    {
        $pick_up_requests = $pickUp->pickupRequest;

        if($pick_up_requests->count() > 0)
        {
            $pick_up_requests->map(function ($pick_up_request){

                $pick_up_request->delete();
            });
        }

        $pickUp->delete();

        return response()->json(['message' => 'deleted']);

    }

    public function viewPickUpDays()
    {
        $pick_ups = auth()->guard('wmc_admin')->user()->company->pickUpDay;

        return PickUpResource::collection($pick_ups);
    }

    public function viewPickRequest()
    {
        $company_id = auth()->guard('wmc_admin')->user()->company->id;

        $pick_up_requests = DB::table('pick_up_requests')
            ->join('pick_ups', 'pick_up_requests.pick_up_id', '=', 'pick_ups.id')
            ->select('pick_up_requests.*', 'pick_ups.day_id')
            ->where('pick_ups.waste_company_id', '=', $company_id)->get();

        return PickUpRequestResource::collection($pick_up_requests);
    }

    public function servePickRequest(PickUpRequest $pickUpRequest)
    {
        $pickUpRequest->update(['status' => 'served']);

        return response()->json(['message' => 'served']);

    }
}
