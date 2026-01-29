<?php

// namespace Database\Seeders;

// use App\Models\Admin;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
// use Illuminate\Database\Seeder;
// use Illuminate\Support\Facades\Hash;

// class AdminSeeder extends Seeder
// {
//     /**
//      * Run the database seeds.
//      *
//      * @return void
//      */
//     public function run()
//     {
//         Admin::create([
//             'name'=>'admin',
//             'email'=>'admin@email.com',
//             'password'=>Hash::make('123456'),
//             'admin_type'=>'1',
//         ]);<?php
 
namespace Database\Seeders;
 
use App\Models\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Role;
 
 
class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
 
        $superAdminRole = Role::where('name', 'Super Admin')->first();
 
        Admin::create([
            'name' => 'admin',
            'email' => 'admin@email.com',
            'password' => Hash::make('123456'),
            'admin_type' => '1',
            'role_id' => $superAdminRole->id,
 
        ]);
    }
}
 
 
//     }
// }
