<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Ads;
use App\Models\Currency;
use App\Models\Faq;
use App\Models\FeaturedLink;
use App\Models\ShippingCost;
use Illuminate\Http\Request;
use App\Models\Country;
use App\Models\Division; // division = state
use App\Models\District; // district = city

class SettingController extends Controller
{
    // public function shippingCost(Request $request){
    //      $divisionId=$request['division_id'];
    //      $districtId=$request['district_id'];
    //      $shippingCost=0;
    //      $list=ShippingCost::where('division_id',$divisionId)->where('district_id',$districtId)->first();
    //      $shippingInfo=ShippingCost::first();
    //      if($list){
    //          $shippingCost=$shippingInfo->inside_price;
    //      }else{
    //          $shippingCost=$shippingInfo->outside_price;
    //      }
    //      return response()->json($shippingCost);
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



    public function shippingCost(Request $request)
    {
        $divisionId = (int) $request->division_id;
        $districtId = (int) $request->district_id;

        // If division or district not selected → outside price
        if ($divisionId === 0 || $districtId === 0) {
            $default = ShippingCost::first();
            return response()->json($default ? $default->outside_price : 0);
        }

        // Try exact match
        $row = ShippingCost::where('division_id', $divisionId)
            ->where('district_id', $districtId)
            ->first();

        if ($row) {
            return response()->json($row->inside_price);
        }

        // Fallback → outside price
        $default = ShippingCost::first();
        return response()->json($default ? $default->outside_price : 0);
    }


    public function currency()
    {
        $currency = Currency::first();
        return response()->json($currency);
    }

    public function featuredList()
    {
        $link = FeaturedLink::where('is_active', 1)->get()->take(3);
        return response()->json($link);
    }
    public function getFaq()
    {
        $faqData = Faq::get();
        return response()->json($faqData);
    }

    public function getAds()
    {
        $first = Ads::where('position', 1)->orderBy('position', 'asc')->get();
        $second = Ads::Where('position', 2)->orderBy('position', 'asc')->get();
        $list = [
            'first' => $first,
            'second' => $second,
        ];
        return response()->json($list);
    }
}
