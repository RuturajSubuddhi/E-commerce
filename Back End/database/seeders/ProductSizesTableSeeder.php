<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ProductSizesTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('product_sizes')->truncate();

        $now = Carbon::now();

        $sizes = ['XS', 'S', 'M', 'L', 'XL', 'XXL', '3XL', 'Free Size', 'One Size'];

        foreach ($sizes as $size) {
            DB::table('product_sizes')->insert([
                'size' => $size,
                'created_at' => $now,
                'updated_at' => $now
            ]);
        }
    }
}
