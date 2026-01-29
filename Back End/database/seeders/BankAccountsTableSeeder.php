<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BankAccountsTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('bank_accounts')->truncate();

        $now = Carbon::now();

        $accounts = [
            [
                'bank_name' => 'State Bank of India',
                'account_type' => 'Savings',
                'account_number' => '123456789012',
                'phone' => '9876543210',
                'branch_name' => 'Andheri West, Mumbai',
                'note' => 'Primary business account',
                'available_balance' => 250000.00,
                'status' => 1,
                'created_at' => $now,
            ],
            [
                'bank_name' => 'HDFC Bank',
                'account_type' => 'Current',
                'account_number' => '987654321098',
                'phone' => '9876501122',
                'branch_name' => 'Connaught Place, Delhi',
                'note' => 'Corporate account',
                'available_balance' => 850000.50,
                'status' => 1,
                'created_at' => $now,
            ],
            [
                'bank_name' => 'ICICI Bank',
                'account_type' => 'Savings',
                'account_number' => '112233445566',
                'phone' => '9812314567',
                'branch_name' => 'MG Road, Bengaluru',
                'note' => 'Employee expense account',
                'available_balance' => 120000.75,
                'status' => 1,
                'created_at' => $now,
            ],
            [
                'bank_name' => 'Axis Bank',
                'account_type' => 'Current',
                'account_number' => '998877665544',
                'phone' => '9823456789',
                'branch_name' => 'Park Street, Kolkata',
                'note' => 'Supplier payment account',
                'available_balance' => 460000.00,
                'status' => 1,
                'created_at' => $now,
            ],
            [
                'bank_name' => 'Punjab National Bank',
                'account_type' => 'Savings',
                'account_number' => '778899665544',
                'phone' => '9811122233',
                'branch_name' => 'Sector 17, Chandigarh',
                'note' => 'Personal backup account',
                'available_balance' => 80000.25,
                'status' => 1,
                'created_at' => $now,
            ],
            [
                'bank_name' => 'Kotak Mahindra Bank',
                'account_type' => 'Business',
                'account_number' => '665544332211',
                'phone' => '9876123400',
                'branch_name' => 'Anna Nagar, Chennai',
                'note' => 'E-commerce transaction account',
                'available_balance' => 300000.00,
                'status' => 1,
                'created_at' => $now,
            ],
            [
                'bank_name' => 'Canara Bank',
                'account_type' => 'Savings',
                'account_number' => '110022003344',
                'phone' => '9898989898',
                'branch_name' => 'Ernakulam, Kerala',
                'note' => 'Refund reserve account',
                'available_balance' => 55000.75,
                'status' => 1,
                'created_at' => $now,
            ],
            [
                'bank_name' => 'Union Bank of India',
                'account_type' => 'Current',
                'account_number' => '556677889900',
                'phone' => '9776655443',
                'branch_name' => 'Patna Main Branch',
                'note' => 'Vendor payment account',
                'available_balance' => 145000.00,
                'status' => 1,
                'created_at' => $now,
            ],
            [
                'bank_name' => 'Bank of Baroda',
                'account_type' => 'Savings',
                'account_number' => '998800776655',
                'phone' => '9855566778',
                'branch_name' => 'Vastrapur, Ahmedabad',
                'note' => 'Staff salary account',
                'available_balance' => 230000.00,
                'status' => 1,
                'created_at' => $now,
            ],
            [
                'bank_name' => 'IndusInd Bank',
                'account_type' => 'Business',
                'account_number' => '445566778899',
                'phone' => '9765432100',
                'branch_name' => 'Baner, Pune',
                'note' => 'Marketing operations account',
                'available_balance' => 410000.00,
                'status' => 1,
                'created_at' => $now,
            ],
        ];

        DB::table('bank_accounts')->insert($accounts);
    }
}
