<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class BinRequestResource extends ResourceCollection
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return $this->collection->map(function($bin_request){

             return [

                 'garbage_type' => $bin_request->garbage_type,

                 'organization' => $bin_request->organization ?? null,

                 'user' => $bin_request->client ?? null,
             ];

        });
    }
}
