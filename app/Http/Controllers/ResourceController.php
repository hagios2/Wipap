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

    public function getCampus()
    {
        return CampusResource::collection(Campus::all('id', 'campus'));
    }


    public function getShopTypes()
    {
        return CampusResource::collection(ShopType::all('id', 'shop_type'));
    }

    public function getGarbageTypes()
    {
       return GarbageType::all('id', 'garbage_type');
    }


}
