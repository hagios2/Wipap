<?php

namespace App\Http\Controllers\WMCControllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\PickUpRequestResource;
use App\Http\Resources\PickUpResource;
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
        $request->validate(['day_id']);

        auth()->guard('wmc_admin')->user()->company->setPickupDay();

        return response()->json(['message' => 'saved']);
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
            ->where('pick_ups.waste_company_id', '=', $company_id);

        return PickUpRequestResource::collection($pick_up_requests);
    }
}
