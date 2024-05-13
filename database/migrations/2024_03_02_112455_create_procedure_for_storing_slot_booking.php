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
            CREATE PROCEDURE insert_schedule_slot(
                IN p_call_id VARCHAR(255),
                IN p_customer_id INT,
                IN p_vendor_id INT,
                IN p_type ENUM(\'online\', \'physical\'),
                IN p_date DATE,
                IN p_preferred_time_1 TIME,
                IN p_preferred_time_2 TIME,
                IN p_communication_mode ENUM(\'chat\', \'video\', \'audio\'),
                IN p_status ENUM(\'completed\', \'cancelled\', \'booked\')
            )
            BEGIN
                INSERT INTO schedule_slots (call_id, customer_id, vendor_id, type, date, preferred_time_1, preferred_time_2, communication_mode, status, created_at, updated_at)
                VALUES (p_call_id, p_customer_id, p_vendor_id, p_type, p_date, p_preferred_time_1, p_preferred_time_2, p_communication_mode, p_status, NOW(), NOW());
            END;        
        ');
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS insert_schedule_slot');
    }
};
