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
        Schema::create('tbl_service_requests', function (Blueprint $table) {
            $table->id();
            $table->integer('site_id')->nullable();
            $table->string('request_type_id',200)->nullable();
            $table->enum('busniness_waste_status', ['0', '1'])->default('1')->comment('0: inactive, 1: active');
            $table->enum('complaint_option_status', ['0', '1'])->default('1')->comment('0: inactive, 1: active');
            $table->string('title',200)->nullable();
            $table->string('job_title',200)->nullable();
            $table->string('first_name',200)->nullable();
            $table->string('last_name',200)->nullable();
            $table->string('home_telephone',200)->nullable();
            $table->string('work_telephone',200)->nullable();
            $table->text('address')->nullable();
            $table->string('email',200)->nullable();
            $table->text('address2')->nullable();
            $table->string('ethnicity',200)->nullable();
            $table->string('complaint_town',255)->nullable();
            $table->string('gender',100)->nullable();
            $table->string('complaint_country',200)->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('complaint_postal_code',200)->nullable();
            $table->string('busniness_name',200)->nullable();
            $table->string('busniness_address',200)->nullable();
            $table->string('busniness_town',200)->nullable();
            $table->string('busniness_country',200)->nullable();
            $table->string('busniness_post_code',200)->nullable();
            $table->integer('reported_via_id')->nullable();
            $table->integer('officer_id')->nullable();
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
        Schema::dropIfExists('service_requests');
    }
};
