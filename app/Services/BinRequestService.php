<?php

namespace App\Services;

use App\BinRequest;
use App\Http\Requests\BinFormRequest;
use App\Http\Resources\BinRequestResource;
use \App\Bin;

class BinRequestService
{
    public function fetchBinRequest(): BinRequestResource
    {
        if(auth()->user()->organization)
        {
            $bin_collections = BinRequest::query()->where('organization_id', auth()->user()->organization_id)->latest()->paginate(10);
        }else{

            $bin_collections = BinRequest::query()->where('user_id', auth()->id())->latest()->paginate(10);
        }

        return new BinRequestResource($bin_collections);
    }

    public function storeBinRequest(BinFormRequest $request): \Illuminate\Http\JsonResponse
    {
        $validated_data = $request->validated();

        if(auth()->user()->organization)
        {
            auth()->user()->organization->makeABinRequest($validated_data);

        }else{

            auth()->user()->makeABinRequest($validated_data);
        }

        return response()->json(['message' => 'bin request saved'], 201);
    }

    public function addBinReplacement(Bin $bin)
    {
    }
}
