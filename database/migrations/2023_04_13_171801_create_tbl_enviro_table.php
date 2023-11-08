<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_enviro', function (Blueprint $table) {
            $table->id();
            $table->string('fpn_number');
            $table->string('barcode')->nullable();
            $table->integer('site_id');
            $table->integer('zone_id');
            $table->integer('officer_id');
            $table->integer('offence_id');
            $table->integer('offence_type_id');
            $table->string('language')->nullable();
            $table->integer('admin_id')->nullable();
            $table->integer('offender_id');
            $table->integer('prefix_id')->nullable();
            $table->integer('location_id');
            $table->integer('action_id');
            $table->string('caution')->nullable();
            $table->string('second_caution')->nullable();
            $table->integer('offender_reply')->nullable();
            $table->string('description')->nullable();
            $table->string('description_waste')->nullable();
            $table->string('offence_location');
            $table->integer('land_type_id');
            $table->string('town_area')->nullable();
            $table->integer('poi_prefix_id')->nullable();
            $table->string('poi')->nullable();
            $table->integer('visibility_id');
            $table->integer('weather_id');
            $table->string('offence_datetime');
            $table->string('issue_datetime');
            $table->integer('enviro_issued_onspot')->default(0);
            $table->integer('is_witness_available')->default(0);
            $table->string('officer_statement')->nullable();
            $table->string('signature')->nullable()->comment('Signature image');
            $table->integer('is_paid')->default(0)->comment('0: Not Paid, 1: Paid');
            $table->integer('is_rep_logged')->default(0)->comment('0: Not Logged, 1: Logged');
            $table->enum('fpn_status', ['issued','paid','rep_logged'])->default('issued');
            $table->string('payment_datetime')->nullable();
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
        Schema::dropIfExists('tbl_enviro');
    }
};
