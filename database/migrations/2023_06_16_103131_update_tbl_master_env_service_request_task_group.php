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
        Schema::table('tbl_master_env_service_request_task_group', function (Blueprint $table) {
            $table->dropColumn('site_id');
            $table->dropColumn('task_type_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tbl_master_env_service_request_task_group', function (Blueprint $table) {
            $table->integer('site_id');
            $table->integer('task_type_id');
        });
    }
};
