<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Division; // division = state
use App\Models\District; // district = city
use Illuminate\Http\Request;

class StorageController extends Controller
{
    // public function countryList(){
    //     $country_list=countryList();
    //     return response()->json($country_list);
    // }
    // public function divisionList(){
    //     $division_list=Division::get();
    //     return response()->json($division_list);
    // }
    // public function districtList(Request $request){

    //    $divisionList= District::where('division_id',$request->divisionId)->get();
    //     return response()->json($divisionList);
    // }
    // Get all countries
    public function countryList()
    {
        return response()->json(Country::all());
    }

    // Get states by country
    public function divisionList(Request $request)
    {
        $countryId = $request->query('country_id');
        $states = Division::when($countryId, function ($q, $countryId) {
            return $q->where('country_id', $countryId);
        })->get();
        return response()->json($states);
    }

    // Get cities by state
    // public function districtList(Request $request)
    // {
    //     $stateId = $request->query('division_id');
    //     $cities = District::when($stateId, function ($q, $stateId) {
    //         return $q->where('division_id', $stateId);
    //     })->get();
    //     return response()->json($cities);
    // }

    public function districtList(Request $request)
    {
        $stateId = (int) $request->query('division_id');

        if (!$stateId) {
            return response()->json([]);
        }

        $cities = District::where('division_id', $stateId)->get();
        return response()->json($cities);
    }
}
