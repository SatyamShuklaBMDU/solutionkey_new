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
        Schema::create('schedule_slots', function (Blueprint $table) {
            $table->id();
            $table->string('call_id')->unique();
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('vendor_id');
            $table->foreign('vendor_id')->references('id')->on('vendors')->onDelete('cascade');
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
            $table->enum('type', ['online', 'physical']);
            $table->date('date');
            $table->time('preferred_time_1');
            $table->time('preferred_time_2')->nullable();
            $table->enum('communication_mode', ['chat', 'video', 'audio'])->nullable();
            $table->enum('status', ['completed','cancelled','booked']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedule_slots');
    }
};
