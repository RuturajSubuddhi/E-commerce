<?php
 
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
 
return new class extends Migration
{
    public function up()
    {
        Schema::create('sell_returns', function (Blueprint $table) {
            $table->id();
 
            // Correct Column Names
            $table->unsignedBigInteger('sell_id');  // sell_id → order_id
            $table->unsignedBigInteger('user_id');   // customer
 
            // Return Details
            $table->string('reason')->nullable();
            $table->text('comment')->nullable();
 
            // Image
            $table->string('image')->nullable();
 
            // Return Status
            // 0 = pending, 1 = approved, 2 = rejected, 3 = completed
            $table->tinyInteger('status')->default(0);
 
            $table->timestamps();
 
            // Foreign Keys
            $table->foreign('sell_id')->references('id')->on('sells')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }
 
    public function down()
    {
        Schema::dropIfExists('sell_returns');
    }
};