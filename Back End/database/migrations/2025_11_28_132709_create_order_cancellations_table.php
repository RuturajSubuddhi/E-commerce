<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('order_cancellations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sell_id');   // Order reference
            $table->unsignedBigInteger('user_id');   // Customer
            $table->string('reason');
            $table->text('comment')->nullable();
            $table->timestamp('requested_at')->nullable();
            $table->tinyInteger('status')->default(0)
                ->comment('0=pending,1=approved,2=rejected');
            $table->timestamp('approved_at')->nullable();
            $table->timestamp('rejected_at')->nullable();
            $table->timestamps();

            $table->foreign('sell_id')->references('id')->on('sells')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('order_cancellations');
    }
};
