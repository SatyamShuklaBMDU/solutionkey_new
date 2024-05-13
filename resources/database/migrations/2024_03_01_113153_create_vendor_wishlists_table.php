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
        Schema::create('vendor_wishlists', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id')->comment('This Id is come from Customers Table.');
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
            $table->unsignedBigInteger('vendors_id')->comment('This Id is come from Vendors Table.');
            $table->foreign('vendors_id')->references('id')->on('vendors')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vendor_wishlists');
    }
};
