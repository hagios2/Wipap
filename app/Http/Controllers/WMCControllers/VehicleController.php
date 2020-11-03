<?php

namespace App\Http\Controllers\WMCControllers;

use App\BinRequest;
use App\Http\Controllers\Controller;
use App\Http\Requests\VehicleRequest;
use App\Http\Resources\BinRequestResource;
use App\Http\Resources\VehicleResource;
use App\Vehicle;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:wmc_admin');
    }

    public function addVehicle(VehicleRequest $request)
    {
        $vehicle = $request->validated();

        $vehicle['waste_company_id'] = auth()->guard('wmc_admin')->user()->waste_company_id;

        Vehicle::create($vehicle);

        return response()->json(['message' => 'success'], 200);
    }

    public function fetchVehicles()
    {
        $vehicles = Vehicle::query()->where('waste_company_id', auth()->guard('wmc_admin')->user()->waste_company_id)->get();

        return VehicleResource::collection($vehicles);
    }

    public function updateVehicle(Vehicle $vehicle, VehicleRequest $request)
    {
        $vehicle->update($request->validated());

        return response()->json(['message' => 'vehicle updated']);
    }

    public function deleteVehicle(Vehicle $vehicle)
    {
        $vehicle->delete();

        return response()->json(['message' => 'vehicle deleted']);
    }


    public function viewBinRequest()
    {
        $requests = BinRequest::query()->where('waste_company_id', auth()->guard('wmc_admin')->user()->waste_company_id);

        return new BinRequestResource($requests);
    }


}
