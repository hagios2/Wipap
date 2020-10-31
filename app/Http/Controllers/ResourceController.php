<?php

namespace App\Http\Controllers;

use App\Campus;
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

    public function getCourosleIamges(Campus $campus)
    {
       $carousel = CarouselControl::where('campus_id', $campus->id)->latest()->get();

       return $carousel;

       //return response()->json(['images', $carousel]);
    }
}
