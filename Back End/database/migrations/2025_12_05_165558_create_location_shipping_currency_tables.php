<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // ----------------------------
        // Countries Table
        // ----------------------------
        Schema::create('countries', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code', 5)->nullable(); // ISO code
            $table->timestamps();
        });

        // ----------------------------
        // Divisions Table (States/Provinces)
        // ----------------------------
        Schema::create('divisions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('country_id')->constrained('countries')->onDelete('cascade');
            $table->string('name');
            $table->timestamps();
        });

        // ----------------------------
        // Districts Table
        // ----------------------------
        Schema::create('districts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('division_id')->constrained('divisions')->onDelete('cascade');
            $table->string('name');
            $table->timestamps();
        });

        // ----------------------------
        // Cities Table
        // ----------------------------
        Schema::create('cities', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('division_id')->constrained('divisions')->onDelete('cascade');
            $table->foreignId('district_id')->constrained('districts')->onDelete('cascade');
            $table->timestamps();
        });

        // ----------------------------
        // Shipping Costs Table
        // ----------------------------
        Schema::create('shipping_costs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('division_id')->constrained('divisions')->onDelete('cascade');
            $table->foreignId('district_id')->constrained('districts')->onDelete('cascade');
            $table->decimal('inside_price', 10, 2)->default(0);
            $table->decimal('outside_price', 10, 2)->default(0);
            $table->timestamps();
        });

        // ----------------------------
        // Currencies Table
        // ----------------------------
        Schema::create('currencies', function (Blueprint $table) {
            $table->id();
            $table->string('country_name')->nullable();
            $table->string('currency_code', 5)->nullable(); // USD, INR, EUR
            $table->string('currency_symbol'); // $, ₹
            $table->decimal('par_dollar_rate', 11, 2)->default(1);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('currencies');
        Schema::dropIfExists('shipping_costs');
        Schema::dropIfExists('cities');
        Schema::dropIfExists('districts');
        Schema::dropIfExists('divisions');
        Schema::dropIfExists('countries');
    }
};
