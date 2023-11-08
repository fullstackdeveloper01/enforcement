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
        Schema::create('tbl_master_env_service_request_reported_via', function (Blueprint $table) {
            $table->id();
            $table->string('reported_via');
            $table->enum('status', ['0', '1'])->default('1')->comment('0: inactive, 1: active');
            $table->enum('is_back_office', ['0', '1'])->default('1')->comment('0: no, 1: yes');
            $table->enum('is_online', ['0', '1'])->default('1')->comment('0: no, 1: yes');
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
        Schema::dropIfExists('tbl_master_env_service_request_reported_via');
    }
};
