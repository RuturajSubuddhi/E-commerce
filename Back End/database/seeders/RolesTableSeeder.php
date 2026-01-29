<?php
 
namespace Database\Seeders;
 
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
 
class RolesTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('roles')->insert([
            [
                'name' => 'Super Admin',
                'access_role_list' => 'h1,1,2,h2,3,4,h3,5,6,7,8,h4,9,h5,10,h6,12,h7,14,h8,15,16,17,18,19,20,21,h9,22,23',
                'status' => 1,
            ],
            [
                'name' => 'POS Manager',
                'access_role_list' => 'h2,3,4,5',
                'status' => 1,
            ],
            [
                'name' => 'Product Manager',
                'access_role_list' => 'h3,5,6,7,8',
                'status' => 1,
            ],
        ]);
    }
}
 
 