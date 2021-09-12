<?php

namespace App\Http\Controllers;

use App\Company;
use App\WasteCompany;
use Carbon\Carbon;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    public function appLog($message)
    {
        $now = Carbon::parse(now());
        file_put_contents(storage_path() . '/logs/app_payment.log', "\n" . $now . ' || ' .$message . PHP_EOL, FILE_APPEND);
    }


}
