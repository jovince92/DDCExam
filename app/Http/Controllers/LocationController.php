<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Province;
use App\Models\Region;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function regions(){
        $regions= Region::all();        
        return $regions;
    }

    public function provinces(Request $request){
        $provinces=Province::where('regCode',$request->region_id)->get();
        return $provinces;
    }
    public function cities(Request $request){
        $cities=City::where('provCode',$request->province_id)->get();
        return $cities;
    }

    public function locations(){
        $regions=Region::all();
        $provinces=Province::all();
        $cities=City::all();

        $locations=[
            'regions'=>$regions,
            'provinces'=>$provinces,
            'cities'=>$cities
        ];
        // dd($locations);
        return $locations;
    }
}
