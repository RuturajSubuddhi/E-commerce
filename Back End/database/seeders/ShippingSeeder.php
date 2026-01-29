<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Country;
use App\Models\Division;
use App\Models\District;
use App\Models\Currency;
use App\Models\ShippingCost;

class ShippingSeeder extends Seeder
{
    public function run(): void
    {
        // ------------------------
        // Seed Countries
        // ------------------------
        $countries = [
            ['name' => 'India', 'code' => 'IN'],
            ['name' => 'United States', 'code' => 'US'],
            ['name' => 'United Kingdom', 'code' => 'UK'],
        ];

        foreach ($countries as $countryData) {
            Country::updateOrCreate(['code' => $countryData['code']], $countryData);
        }

        // ------------------------
        // Seed Divisions (States/Provinces)
        // ------------------------
        $india = Country::where('code', 'IN')->first();
        $us = Country::where('code', 'US')->first();
        $uk = Country::where('code', 'UK')->first();

        $divisions = [
            ['country_id' => $india->id, 'name' => 'Maharashtra'],
            ['country_id' => $india->id, 'name' => 'Karnataka'],
            ['country_id' => $us->id, 'name' => 'California'],
            ['country_id' => $us->id, 'name' => 'Texas'],
            ['country_id' => $uk->id, 'name' => 'England'],
            ['country_id' => $uk->id, 'name' => 'Scotland'],
        ];

        foreach ($divisions as $divisionData) {
            Division::updateOrCreate(
                ['country_id' => $divisionData['country_id'], 'name' => $divisionData['name']],
                $divisionData
            );
        }

        // ------------------------
        // Seed Districts
        // ------------------------
        $districts = [
            ['division' => 'Maharashtra', 'name' => 'Mumbai'],
            ['division' => 'Maharashtra', 'name' => 'Pune'],
            ['division' => 'Karnataka', 'name' => 'Bengaluru'],
            ['division' => 'Karnataka', 'name' => 'Mysuru'],
            ['division' => 'California', 'name' => 'Los Angeles'],
            ['division' => 'California', 'name' => 'San Francisco'],
            ['division' => 'Texas', 'name' => 'Houston'],
            ['division' => 'Texas', 'name' => 'Dallas'],
            ['division' => 'England', 'name' => 'London'],
            ['division' => 'Scotland', 'name' => 'Edinburgh'],
        ];

        foreach ($districts as $districtData) {
            $division = Division::where('name', $districtData['division'])->first();
            District::updateOrCreate(
                ['division_id' => $division->id, 'name' => $districtData['name']],
                ['division_id' => $division->id, 'name' => $districtData['name']]
            );
        }

        // ------------------------
        // Seed Currency
        // ------------------------
        $currencies = [
            ['country_name' => 'India', 'currency_code' => 'INR', 'currency_symbol' => '₹', 'par_dollar_rate' => 83.50],
            ['country_name' => 'United States', 'currency_code' => 'USD', 'currency_symbol' => '$', 'par_dollar_rate' => 1],
            ['country_name' => 'United Kingdom', 'currency_code' => 'GBP', 'currency_symbol' => '£', 'par_dollar_rate' => 0.75],
        ];

        foreach ($currencies as $currencyData) {
            Currency::updateOrCreate(
                ['country_name' => $currencyData['country_name']],
                $currencyData
            );
        }

        // ------------------------
        // Seed Shipping Costs
        // ------------------------
        $allDivisions = Division::all();
        foreach ($allDivisions as $division) {
            foreach ($division->districts as $district) {
                ShippingCost::updateOrCreate(
                    ['division_id' => $division->id, 'district_id' => $district->id],
                    ['inside_price' => rand(50, 200), 'outside_price' => rand(200, 500)]
                );
            }
        }

        $this->command->info('Countries, Divisions, Districts, Currencies, and Shipping Costs seeded successfully.');
    }
}
