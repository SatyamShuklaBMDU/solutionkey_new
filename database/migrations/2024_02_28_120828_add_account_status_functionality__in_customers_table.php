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
        Schema::table('customers', function(Blueprint $table) {
            $table->unsignedTinyInteger('account_status')->default(1)->after('profile_pic');
            $table->timestamp('deactivated_at')->nullable()->after('account_status');
            $table->text('deactivation_remark')->nullable()->after('deactivated_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            //
        });
    }
};
