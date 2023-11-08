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
        Schema::create('tbl_master_env_manual_representation_reason', function (Blueprint $table) {
            $table->id();
            $table->string('reason');
            $table->enum('isOnline', ['0', '1'])->default('1')->comment('0: online, 1: offline');
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
        Schema::dropIfExists('tbl_master_env_manual_representation_reason');
    }
};
