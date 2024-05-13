<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('rewards', function (Blueprint $table) {
            $table->id();
            $table->string('reward_type')->comment('Type of Reward.');
            $table->unsignedBigInteger('customer_id')->comment('Reward Getting Person.');
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
            $table->string('points');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rewards');
    }
};
