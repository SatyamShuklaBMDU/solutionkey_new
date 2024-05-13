<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        DB::unprepared('
            CREATE PROCEDURE `filter_vendors` (
                IN designation_filter VARCHAR(255),
                IN area_of_interest_filter VARCHAR(255),
                IN experience_filter VARCHAR(255),
                IN charge_audio_min DECIMAL(8, 2),
                IN charge_audio_max DECIMAL(8, 2),
                IN charge_video_min DECIMAL(8, 2),
                IN charge_video_max DECIMAL(8, 2),
                IN charge_chat_min DECIMAL(8, 2),
                IN charge_chat_max DECIMAL(8, 2),
                IN gender_filter VARCHAR(255),
                IN min_rating INT
            )
            BEGIN
                SELECT v.*
                FROM vendors v
                JOIN reviews r ON v.id = r.vendor_id
                WHERE
                    (designation_filter IS NULL OR v.designation = designation_filter)
                    AND (area_of_interest_filter IS NULL OR v.area_of_interest = area_of_interest_filter)
                    AND (experience_filter IS NULL OR v.experience = experience_filter)
                    AND (charge_audio_min IS NULL OR v.charge_per_minute_for_audio_call >= charge_audio_min)
                    AND (charge_audio_max IS NULL OR v.charge_per_minute_for_audio_call <= charge_audio_max)
                    AND (charge_video_min IS NULL OR v.charge_per_minute_for_video_call >= charge_video_min)
                    AND (charge_video_max IS NULL OR v.charge_per_minute_for_video_call <= charge_video_max)
                    AND (charge_chat_min IS NULL OR v.charge_per_minute_for_chat >= charge_chat_min)
                    AND (charge_chat_max IS NULL OR v.charge_per_minute_for_chat <= charge_chat_max)
                    AND (gender_filter IS NULL OR v.gender = gender_filter)
                    AND r.rating >= min_rating;
            END
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS filter_vendors');
    }
};
