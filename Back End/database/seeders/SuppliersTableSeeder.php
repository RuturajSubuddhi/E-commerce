<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SuppliersTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('suppliers')->truncate();

        $now = Carbon::now();

        DB::table('suppliers')->insert([
            [
                'supplier_name' => 'Akira Importers Pvt Ltd',
                'image' => 'suppliers/akira.png',
                'supplier_phone_one' => '9876543210',
                'supplier_phone_two' => '9123456780',
                'company_name' => 'Akira Anime Goods Co.',
                'company_address' => 'Tokyo Street, Shibuya, Japan',
                'supplier_address' => 'Osaka District, Japan',
                'company_email' => 'info@akiraanime.com',
                'company_phone' => '+81-3-1234-5678',
                'supplier_email' => 'supplier@akiraanime.com',
                'previous_due' => 15000.000,
                'status' => 1,
                'created_at' => $now,
                'created_by' => 1,
                'updated_at' => $now,
                'updated_by' => 1,
                'deleted' => 0,
            ],
            [
                'supplier_name' => 'Shonen Supply House',
                'image' => 'suppliers/shonen.png',
                'supplier_phone_one' => '9988776655',
                'supplier_phone_two' => null,
                'company_name' => 'Shonen Collectibles Inc.',
                'company_address' => 'Osaka, Japan',
                'supplier_address' => 'Tokyo, Japan',
                'company_email' => 'contact@shonencollectibles.jp',
                'company_phone' => '+81-90-8765-4321',
                'supplier_email' => 'sales@shonencollectibles.jp',
                'previous_due' => 0.000,
                'status' => 1,
                'created_at' => $now,
                'created_by' => 1,
                'updated_at' => $now,
                'updated_by' => 1,
                'deleted' => 0,
            ],
            [
                'supplier_name' => 'Otaku Imports',
                'image' => 'suppliers/otaku.png',
                'supplier_phone_one' => '9090909090',
                'supplier_phone_two' => '8080808080',
                'company_name' => 'Otaku Universe LLC',
                'company_address' => 'Seoul, South Korea',
                'supplier_address' => 'Busan, South Korea',
                'company_email' => 'support@otakuuniverse.co.kr',
                'company_phone' => '+82-2-123-4567',
                'supplier_email' => 'partner@otakuuniverse.co.kr',
                'previous_due' => 7250.500,
                'status' => 1,
                'created_at' => $now,
                'created_by' => 1,
                'updated_at' => $now,
                'updated_by' => 1,
                'deleted' => 0,
            ],
            [
                'supplier_name' => 'MangaMart Distribution',
                'image' => 'suppliers/mangamart.png',
                'supplier_phone_one' => '9812345678',
                'supplier_phone_two' => null,
                'company_name' => 'MangaMart Distributors',
                'company_address' => 'Bangalore, India',
                'supplier_address' => 'Delhi, India',
                'company_email' => 'info@mangamart.in',
                'company_phone' => '+91-98765-43210',
                'supplier_email' => 'sales@mangamart.in',
                'previous_due' => 2000.000,
                'status' => 1,
                'created_at' => $now,
                'created_by' => 1,
                'updated_at' => $now,
                'updated_by' => 1,
                'deleted' => 0,
            ],
            [
                'supplier_name' => 'Anime Warehouse Global',
                'image' => 'suppliers/animewarehouse.png',
                'supplier_phone_one' => '9765432109',
                'supplier_phone_two' => '9345678901',
                'company_name' => 'Anime Warehouse Global Pvt Ltd',
                'company_address' => 'Los Angeles, USA',
                'supplier_address' => 'San Francisco, USA',
                'company_email' => 'admin@animewarehouse.com',
                'company_phone' => '+1-213-555-0198',
                'supplier_email' => 'export@animewarehouse.com',
                'previous_due' => 12000.750,
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
