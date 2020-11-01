<?php

namespace App\Http\Controllers;

use App\Campus;
use App\GarbageType;
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


}
