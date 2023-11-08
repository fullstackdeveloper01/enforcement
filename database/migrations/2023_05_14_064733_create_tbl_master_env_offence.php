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
        Schema::create('tbl_master_env_offence', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('welshName')->nullable();
            $table->text('description')->nullable();
            $table->text('welshDescription')->nullable();
            $table->integer('welshLegislation')->nullable();
            $table->integer('englishLegislation');
            $table->integer('group');
            $table->string('minImageRequired');
            $table->string('maxFine');
            $table->integer('issueType');
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
        Schema::dropIfExists('tbl_master_env_offence');
    }
};
