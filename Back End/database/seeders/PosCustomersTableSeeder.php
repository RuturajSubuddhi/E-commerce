<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PosCustomersTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('pos_customers')->truncate();

        $now = Carbon::now();

        $customers = [
            [
                'name' => 'Rohit Sharma',
                'email' => 'rohit.sharma@example.com',
                'image' => 'customers/rohit.png',
                'phone' => '9876543210',
                'address' => 'Mumbai, Maharashtra',
                'available_balance' => 1200.50,
                'status' => 1,
                'created_at' => $now,
            ],
            [
                'name' => 'Priya Mehta',
                'email' => 'priya.mehta@example.com',
                'image' => 'customers/priya.png',
                'phone' => '9876501122',
                'address' => 'Pune, Maharashtra',
                'available_balance' => 450.00,
                'status' => 1,
                'created_at' => $now,
            ],
            [
                'name' => 'Amit Kumar',
                'email' => 'amit.kumar@example.com',
                'image' => 'customers/amit.png',
                'phone' => '9988776655',
                'address' => 'Delhi, India',
                'available_balance' => 0.00,
                'status' => 1,
                'created_at' => $now,
            ],
            [
                'name' => 'Sneha Patel',
                'email' => 'sneha.patel@example.com',
                'image' => 'customers/sneha.png',
                'phone' => '9823456789',
                'address' => 'Ahmedabad, Gujarat',
                'available_balance' => 200.75,
                'status' => 1,
                'created_at' => $now,
            ],
            [
                'name' => 'Arjun Singh',
                'email' => 'arjun.singh@example.com',
                'image' => 'customers/arjun.png',
                'phone' => '9865321478',
                'address' => 'Chandigarh, Punjab',
                'available_balance' => 120.00,
                'status' => 1,
                'created_at' => $now,
            ],
            [
                'name' => 'Neha Gupta',
                'email' => 'neha.gupta@example.com',
                'image' => 'customers/neha.png',
                'phone' => '9876123400',
                'address' => 'Lucknow, Uttar Pradesh',
                'available_balance' => 875.90,
                'status' => 1,
                'created_at' => $now,
            ],
            [
                'name' => 'Karan Joshi',
                'email' => 'karan.joshi@example.com',
                'image' => 'customers/karan.png',
                'phone' => '9812314567',
                'address' => 'Jaipur, Rajasthan',
                'available_balance' => 1345.00,
                'status' => 1,
                'created_at' => $now,
            ],
            [
                'name' => 'Divya Nair',
                'email' => 'divya.nair@example.com',
                'image' => 'customers/divya.png',
                'phone' => '9823459911',
                'address' => 'Kochi, Kerala',
                'available_balance' => 300.00,
                'status' => 1,
                'created_at' => $now,
            ],
            [
                'name' => 'Rahul Verma',
                'email' => 'rahul.verma@example.com',
                'image' => 'customers/rahul.png',
                'phone' => '9874598732',
                'address' => 'Bhopal, Madhya Pradesh',
                'available_balance' => 780.50,
                'status' => 1,
                'created_at' => $now,
            ],
            [
                'name' => 'Simran Kaur',
                'email' => 'simran.kaur@example.com',
                'image' => 'customers/simran.png',
                'phone' => '9811122233',
                'address' => 'Amritsar, Punjab',
                'available_balance' => 560.25,
                'status' => 1,
                'created_at' => $now,
            ],
        ];

        DB::table('pos_customers')->insert($customers);
    }
}
