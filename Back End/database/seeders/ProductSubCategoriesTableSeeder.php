<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class ProductSubCategoriesTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('product_sub_categories')->truncate();

        $now = Carbon::now();

        $subcategories = [
            // Posters
            [1, 'One Piece'], [1, 'Jujutsu Kaisen'], [1, 'Naruto'], [1, 'Dragon Ball Z'],
            [1, 'Demon Slayer'], [1, 'Attack on Titan'], [1, 'Chainsaw Man'], [1, 'Bleach'],
            [1, 'Solo Leveling'], [1, 'My Hero Academia'], [1, 'Marvels'], [1, 'Cars'],

            // Action Figures
            [2, 'One Piece'], [2, 'Jujutsu Kaisen'], [2, 'Naruto'], [2, 'Dragon Ball Z'],
            [2, 'Demon Slayer'], [2, 'Attack on Titan'], [2, 'Chainsaw Man'], [2, 'Bleach'],
            [2, 'Solo Leveling'], [2, 'My Hero Academia'], [2, 'Marvels'],

            // Keychains
            [3, 'Metal Keychains'], [3, 'Katana Keychains'], [3, 'One Piece'], [3, 'Jujutsu Kaisen'],
            [3, 'Naruto'], [3, 'Dragon Ball Z'], [3, 'Demon Slayer'], [3, 'Chainsaw Man'],
            [3, 'Marvels'], [3, 'Hello Kitty'], [3, 'Princess'], [3, 'Tom n Jerry'], [3, 'Panda'],
            [3, 'Cricketers'], [3, 'Miles Morales Spider-Man'], [3, 'Unicorn'], [3, 'Astronaut'],
            [3, 'Batman'], [3, 'Superman'], [3, 'Pokémon'], [3, 'Doremon'], [3, 'Footballers'],
            [3, 'Starbucks'], [3, 'Camera Keychains'],

            // Katana
            [4, 'Wooden Katanas (Real Size 104cm)'],
            [4, 'Mini Wooden Katanas (40cm)'],
            [4, 'Steel Katana (Medium Size 25cm)'],
            [4, 'Steel Katanas (Small Size 15cm)'],

            // Led Katana
            [5, 'Wooden Katanas (Real Size 104cm)'],

            // Deskmates
            [6, 'Anime Desk Figures'],

            // Merch
            [7, 'T-shirt'], [7, 'Oversized'], [7, 'Hoodies'],

            // Mobile Covers
            [8, 'Android'], [8, 'iPhone'],
        ];

        foreach ($subcategories as $sub) {
            DB::table('product_sub_categories')->insert([
                'category_id' => $sub[0],
                'name' => $sub[1],
                // 'slug' => Str::slug($sub[1]),
                'status' => 1,
                'created_at' => $now,
                'updated_at' => $now
            ]);
        }
    }
}
