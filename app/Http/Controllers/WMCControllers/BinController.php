<?php

namespace App\Http\Controllers\WMCControllers;

use App\Bin;
use App\Http\Controllers\Controller;
use App\Http\Requests\BinFormRequest;
use App\Services\BinRequestService;


class BinController extends Controller
{
    private $binRequestService;

    public function __construct(BinRequestService $binRequestService)
    {
        $this->binRequestService = $binRequestService;
    }

    public function storeBin(BinFormRequest $request)
    {
        $this->binRequestService->storeBinRequest($request);
    }

    public function viewBinRequests(): \App\Http\Resources\BinRequestResource
    {
        return $this->binRequestService->fetchBinRequest();
    }

    public function requestBinReplacement(Bin $bin)
    {
        return $this->binRequestService->addBinReplacement($bin);
    }
}
