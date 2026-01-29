<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ProductCategoriesTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('product_categories')->truncate();

        $now = Carbon::now();

        DB::table('product_categories')->insert([
            ['id' => 1, 'name' => 'Poster', 'image' => 'poster.png', 'note' => 'Anime and artistic posters', 'status' => 1, 'is_popular' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['id' => 2, 'name' => 'Action Figures', 'image' => 'action_figures.png', 'note' => 'Anime collectible action figures', 'status' => 1, 'is_popular' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['id' => 3, 'name' => 'Keychains', 'image' => 'keychains.png', 'note' => 'Stylish anime & themed keychains', 'status' => 1, 'is_popular' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['id' => 4, 'name' => 'Katana', 'image' => 'katana.png', 'note' => 'Wooden and steel katanas for collectors', 'status' => 1, 'is_popular' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['id' => 5, 'name' => 'Led Katana', 'image' => 'led_katana.png', 'note' => 'LED powered wooden katanas', 'status' => 1, 'is_popular' => 0, 'created_at' => $now, 'updated_at' => $now],
            ['id' => 6, 'name' => 'Deskmates', 'image' => 'deskmates.png', 'note' => 'Mini anime desk decorations', 'status' => 1, 'is_popular' => 0, 'created_at' => $now, 'updated_at' => $now],
            ['id' => 7, 'name' => 'Merch', 'image' => 'merch.png', 'note' => 'Anime themed clothing and wearables', 'status' => 1, 'is_popular' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['id' => 8, 'name' => 'Mobile Covers', 'image' => 'mobile_covers.png', 'note' => 'Stylish anime covers for Android & iPhone', 'status' => 1, 'is_popular' => 0, 'created_at' => $now, 'updated_at' => $now],
        ]);
    }
}
