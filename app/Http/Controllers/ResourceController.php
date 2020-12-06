<?php

namespace App\Http\Controllers;

use App\Campus;
use App\Day;
use App\GarbageType;
use App\Role;
use App\ShopType;
use App\CarouselControl;
use Illuminate\Http\Request;
use App\Http\Resources\CampusResource;

class ResourceController extends Controller
{
    public function getGarbageTypes()
    {
       return GarbageType::all('id', 'garbage_type');
    }

    public function roles()
    {
        return Role::where('role','!=', 'super_admin')->get();
    }

    public function day()
    {
        return Day::all('id', 'day');
    }
}
