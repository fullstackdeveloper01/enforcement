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
        Schema::create('tbl_master_env_service_request_task_group', function (Blueprint $table) {
            $table->id();
            $table->integer('site_id');
            $table->integer('task_type_id');
            $table->string('task_group_name');
            $table->enum('status', ['0', '1'])->default('1')->comment('0: inactive, 1: active');
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
        Schema::dropIfExists('tbl_master_env_service_request_task_group');
    }
};
