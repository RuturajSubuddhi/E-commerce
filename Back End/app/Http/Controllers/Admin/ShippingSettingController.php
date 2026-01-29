<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Division;
use App\Models\District;
use App\Models\Currency;
use App\Models\ShippingCost;
use Illuminate\Http\Request;

class ShippingSettingController extends Controller
{
    // Display the page
    public function index()
    {
        $divisionList = Division::orderBy('name')->get();
        $districtList = District::orderBy('name')->get();
        $currencyList = Currency::orderBy('country_name')->get();

        $shippingCost = ShippingCost::first() ?? new ShippingCost();
        $currencyData = Currency::first() ?? new Currency();

        return view('adminPanel.setting.shipping_rate', compact(
            'divisionList',
            'districtList',
            'shippingCost',
            'currencyData',
            'currencyList'
        ));
    }

    // Update shipping rate
    public function updateShipping(Request $request)
    {
        $request->validate([
            'division_id' => 'required|exists:divisions,id',
            'district_id' => 'required|exists:districts,id',
            'inside_shipping_cost' => 'required|numeric|min:0',
            'outside_shipping_cost' => 'required|numeric|min:0',
        ]);

        $shippingCost = ShippingCost::first() ?? new ShippingCost();

        $shippingCost->division_id = $request->division_id;
        $shippingCost->district_id = $request->district_id;
        $shippingCost->inside_price = $request->inside_shipping_cost;
        $shippingCost->outside_price = $request->outside_shipping_cost;
        $shippingCost->save();

        return redirect()->back()->with('success', 'Shipping rate updated successfully!');
    }

    // Update currency
    public function updateCurrency(Request $request)
    {
        $request->validate([
            'currency_country' => 'required|string',
            'currency_symbol' => 'required|string',
            'dollar_rate' => 'required|numeric|min:0',
        ]);

        $currencyData = Currency::first() ?? new Currency();
        $currencyData->country_name = $request->currency_country;
        $currencyData->currency_symbol = $request->currency_symbol;
        $currencyData->par_dollar_rate = $request->dollar_rate;
        $currencyData->save();

        return redirect()->back()->with('success', 'Currency updated successfully!');
    }

    // AJAX: get districts by division
    public function getDistrictList(Request $request)
    {
        $districts = District::where('division_id', $request->division_id)->get();

        $html = '<option value="">SELECT DISTRICT</option>';
        foreach ($districts as $district) {
            $html .= '<option value="'.$district->id.'">'.$district->name.'</option>';
        }

        return $html;
    }
}
