<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\District;
use App\Models\Region;
use App\Models\Township;

class AddressController extends Controller
{
    public function getRegions()
    {
        $regions = Region::all();
        return response()->json([
            'regions' => $regions
        ]);
    }

    public function getDistricts(Request $request)
    {
        $districts = District::when($request->region_id, function ($query, $region_id) {
            return $query->where('region_id', $region_id)->get();
        });
        return response()->json([
            'districts' => $districts
        ]);
    }

    public function getTownships(Request $request)
    {
        $townships = Township::when($request->district_id, function ($query, $district_id) {
            return $query->where('district_id', $district_id)->get();
        });
        return response()->json([
            'townships' => $townships
        ]);
    }
}
