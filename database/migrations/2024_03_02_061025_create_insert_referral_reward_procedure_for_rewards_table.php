<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::unprepared('
            CREATE PROCEDURE insert_referral_rewards(
                IN reward_type VARCHAR(255),
                IN customer_id INT,
                IN points INT
            )
            BEGIN
                INSERT INTO rewards (reward_type, customer_id, points, created_at, updated_at)
                VALUES (@reward_type, @customer_id, @points, NOW(), NOW());
            END
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS insert_referral_rewards');
    }
};
