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
        Schema::table('vendor_feedbacks', function (Blueprint $table) {
            $table->string('reply')->nullable()->after('message');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vendor_feedbacks', function (Blueprint $table) {
            $table->dropColumn('reply');
        });
    }
};
