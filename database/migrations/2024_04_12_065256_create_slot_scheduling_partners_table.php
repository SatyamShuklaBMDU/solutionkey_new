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
        Schema::create('slot_scheduling_partners', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('vendor_id')->comment('This ID is from Vendors table');
            $table->foreign('vendor_id')->references('id')->on('vendors')->onDelete('cascade');
            $table->unsignedBigInteger('customer_id')->comment('This ID is from Customer table')->nullable();
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
            $table->string('day_name');
            $table->time('preferred_slot_start1');
            $table->time('preferred_slot_end1');
            $table->time('preferred_slot_start2')->nullable();
            $table->time('preferred_slot_end2')->nullable();
            $table->boolean('is_booked')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('slot_scheduling_partners');
    }
};
