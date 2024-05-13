<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::unprepared('
            CREATE PROCEDURE insert_referral(
                IN from_customer_id INT,
                IN to_customer_id INT,
                IN reward_type VARCHAR(255),
                IN points INT
            )
            BEGIN
                DECLARE referral_id INT;

                -- Insert data into referrals table
                INSERT INTO referrals (from_customer_id, to_customer_id, created_at, updated_at)
                VALUES (from_customer_id, to_customer_id, NOW(), NOW());

                -- Get the last inserted ID from referrals table
                SET referral_id = LAST_INSERT_ID();

                -- Insert data into rewards table
                INSERT INTO rewards (reward_type, customer_id, points, created_at, updated_at)
                VALUES (reward_type, to_customer_id, points, NOW(), NOW());
            END
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS insert_referral');
    }
};
