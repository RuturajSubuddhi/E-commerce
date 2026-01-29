<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ProductBrandsTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('brands')->truncate();

        $now = Carbon::now();

        DB::table('brands')->insert([
            [
                'name' => 'Animezz',
                'image' => 'brands/animezz.png',
                'status' => 1,
                'created_at' => $now,
                'created_by' => 1,
                'updated_at' => $now,
                'updated_by' => 1,
                'deleted' => 0,
            ],
            [
                'name' => 'OtakuWorld',
                'image' => 'brands/otakuworld.png',
                'status' => 1,
                'created_at' => $now,
                'created_by' => 1,
                'updated_at' => $now,
                'updated_by' => 1,
                'deleted' => 0,
            ],
            [
                'name' => 'WeebShop',
                'image' => 'brands/weebshop.png',
                'status' => 1,
                'created_at' => $now,
                'created_by' => 1,
                'updated_at' => $now,
                'updated_by' => 1,
                'deleted' => 0,
            ],
            [
                'name' => 'FigurineHub',
                'image' => 'brands/figurinehub.png',
                'status' => 1,
                'created_at' => $now,
                'created_by' => 1,
                'updated_at' => $now,
                'updated_by' => 1,
                'deleted' => 0,
            ],
            [
                'name' => 'Nippon Artworks',
                'image' => 'brands/nipponartworks.png',
                'status' => 1,
                'created_at' => $now,
                'created_by' => 1,
                'updated_at' => $now,
                'updated_by' => 1,
                'deleted' => 0,
            ],
        ]);
    }
}
