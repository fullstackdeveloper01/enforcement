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
        Schema::create('user_payments', function (Blueprint $table) {
            $table->id();
            $table->string('fpn_number');
            $table->integer('site_id');
            $table->integer('enviro_id');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email');
            $table->string('address_line1');
            $table->string('address_line2')->nullable();
            $table->string('city');
            $table->string('country');
            $table->string('post_code');
            $table->string('phone');
            $table->string('amount');
            $table->string('transaction_id')->nullable();
            $table->integer('status')->default(0)->comment('0: Not Paid, 1: Paid');
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
        Schema::dropIfExists('user_payments');
    }
};
