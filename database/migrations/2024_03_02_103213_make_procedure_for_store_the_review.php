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
            CREATE PROCEDURE insert_review(
                IN customer_id INT,
                IN vendor_id INT,
                IN content VARCHAR(255),
                IN rating INT
            )
            BEGIN
                -- Insert data into review table
                INSERT INTO reviews (customer_id, vendor_id, rating, content, created_at, updated_at)
                VALUES (customer_id, vendor_id, rating, content, NOW(), NOW());
            END
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS insert_review');
    }
};
