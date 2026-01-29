<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ProductColorsTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('product_colors')->truncate();

        $now = Carbon::now();

        $colors = [
            ['name' => 'Red', 'color_code' => '#FF0000'],
            ['name' => 'Blue', 'color_code' => '#0000FF'],
            ['name' => 'Green', 'color_code' => '#008000'],
            ['name' => 'Yellow', 'color_code' => '#FFFF00'],
            ['name' => 'Black', 'color_code' => '#000000'],
            ['name' => 'White', 'color_code' => '#FFFFFF'],
            ['name' => 'Gray', 'color_code' => '#808080'],
            ['name' => 'Purple', 'color_code' => '#800080'],
            ['name' => 'Orange', 'color_code' => '#FFA500'],
            ['name' => 'Pink', 'color_code' => '#FFC0CB'],
            ['name' => 'Gold', 'color_code' => '#FFD700'],
            ['name' => 'Silver', 'color_code' => '#C0C0C0'],
        ];

        foreach ($colors as $color) {
            DB::table('product_colors')->insert([
                'name' => $color['name'],
                'color_code' => $color['color_code'],
                'created_at' => $now,
                'updated_at' => $now
            ]);
        }
    }
}
