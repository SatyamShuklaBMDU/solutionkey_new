<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVendorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendors', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('highest_qualification')->nullable();
            $table->string('designation')->nullable();
            $table->string('area_of_interest')->nullable();
            $table->string('whatsapp_number')->nullable();
            $table->string('email')->nullable();
            $table->string('password')->nullable();
            $table->string('experience')->nullable();
            $table->string('current_job')->nullable();
            $table->decimal('charge_per_minute_for_audio_call', 8, 2)->nullable();
            $table->decimal('charge_per_minute_for_video_call', 8, 2)->nullable();
            $table->decimal('charge_per_minute_for_chat', 8, 2)->nullable();
            $table->string('adhar_number')->nullable();
            $table->string('pancard')->nullable();
            $table->text('about')->nullable();
            $table->boolean('status')->default(1);
            $table->string('profile_picture')->nullable();
            $table->string('cover_picture')->nullable();
            $table->unsignedTinyInteger('account_status')->default(1);
            $table->timestamp('deactivated_at')->nullable();
            $table->text('deactivation_remark')->nullable();
            $table->boolean('is_verified')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vendors');
    }
}
