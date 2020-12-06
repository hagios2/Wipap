<?php

namespace App\Http\Controllers\UserControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BinRequestController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function binRequest(Request $request)
    {
        $bin_request = $request->validate([
            'waste_company_id' => 'required"integer',
            'garbage_type_id' => 'required"integer'
        ]);

        if(auth()->guard('api')->user()->organization)
        {
            $bin_request['organization_id'] = auth()->guard('api')->user()->organization->id;

        }else{

            $bin_request['user_id'] = auth()->guard('api')->id();
        }

        auth()->guard('api')->user()->makeABinRequest($bin_request);

        return response()->json(['message' => 'request saved']);
    }
}
