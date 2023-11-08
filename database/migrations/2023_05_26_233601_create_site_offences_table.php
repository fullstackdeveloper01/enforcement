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
        Schema::create('site_offences', function (Blueprint $table) {
            $table->id();
            $table->integer('site_id');
            $table->integer('offence_id');
            $table->integer('offence_group_id');
            $table->double('charge_amount_reduced')->default(0);
            $table->string('charge_days_reduced')->default(0);
            $table->double('charge_amount_full')->default(0);
            $table->string('charge_days_full')->default(0);
            $table->double('court_fees')->default(0);
            $table->double('max_fine')->default(0);
            $table->integer('status')->default(1);
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
        Schema::dropIfExists('site_offences');
    }
};
