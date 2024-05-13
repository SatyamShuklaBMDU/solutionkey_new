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
        Schema::create('customer_families', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id')->comment('This Id from Customers Table');
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
            $table->string('name');
            $table->enum('gender', ['male', 'female', 'other'])->nullable();
            $table->date('dob')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('email')->unique();
            $table->string('marital_status')->nullable();
            $table->string('password')->nullable();
            $table->text('address')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->unsignedTinyInteger('account_status')->default(1);
            $table->timestamp('deactivated_at')->nullable();
            $table->text('deactivation_remark')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_families');
    }
};
