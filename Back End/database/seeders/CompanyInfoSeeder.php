<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CompanyInfoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('company_infos')->insert([
            'name' => 'Appticode Pvt. Ltd.',
            'email' => 'info@appticode.com',
            'phone' => '+91-9876543210',
            'company_logo' => 'storage/company-logo.png', // ✅ removed leading slash
            'facebook_link' => 'https://www.facebook.com/appticode',
            'youtube_link' => 'https://www.youtube.com/@appticode',
            'twitter_link' => 'https://twitter.com/appticode',
            'company_address' => '4th Floor, IT Park, Pune, Maharashtra, India',
            'about_us' => 'Appticode Pvt. Ltd. is a technology and staffing company providing innovative IT solutions, software development, and training programs for students and enterprises.',
            'refund_policy' => 'Refunds will be processed within 7 working days for eligible requests as per our terms.',
            'privacy_policy' => 'We respect your privacy and ensure that your data is securely stored and never shared with third parties.',
            'shipping_policy' => 'All software and services are delivered electronically. No physical shipping is applicable.',
            'terms_condition' => 'By using our services, you agree to our terms and conditions as stated on the website.',
            'created_at' => Carbon::now()->toDateTimeString(),
            'created_by' => 1,
            'updated_at' => Carbon::now()->toDateTimeString(),
            'updated_by' => 1,
            'deleted' => 0,
            'deleted_at' => null,
            'deleted_by' => null,
        ]);
    }
}
