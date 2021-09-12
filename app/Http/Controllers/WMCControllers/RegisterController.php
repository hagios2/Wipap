<?php

namespace App\Http\Controllers\WMCControllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\WMCRequests\RegistrationRequest;
use App\Jobs\WMCAdminRegistrationJob;
use App\Role;
use App\Services\WMCRegistrationService;
use App\VerifyEmail;
use App\WasteCompany;
use App\WasteCompanyAdmin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    private $registrationService;

    public function __construct(WMCRegistrationService $registrationService)
    {
        $this->registrationService = $registrationService;
    }

    public function register(RegistrationRequest $request): \Illuminate\Http\JsonResponse
    {
        return $this->registrationService->addNewWMC($request);
    }
}
