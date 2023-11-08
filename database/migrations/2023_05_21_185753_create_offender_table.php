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
        Schema::create('tbl_offenders', function (Blueprint $table) {
            $table->id();
            $table->string('salutation');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('address');
            $table->string('town');
            $table->string('county')->nullable();
            $table->string('post_code');
            $table->string('phone')->nullable();
            $table->string('date_of_birth')->nullable();
            $table->string('ethnicity');
            $table->string('gender');
            $table->integer('is_bwc_active')->default(0);
            $table->string('proof_of_address')->nullable();
            $table->string('proof_of_id')->nullable();
            $table->string('ref_no')->nullable();
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
        Schema::dropIfExists('tbl_offenders');
    }
};
