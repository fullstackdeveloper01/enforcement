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
        Schema::create('representation', function (Blueprint $table) {
            $table->id();
            $table->string('fpn_number');
            $table->integer('site_id');
            $table->integer('enviro_id');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email');
            $table->string('address_line1');
            $table->string('city');
            $table->string('country');
            $table->string('post_code');
            $table->string('phone')->nullable();
            $table->string('amount');
            $table->integer('reason');
            $table->text('appeal_note');
            $table->integer('ticket_id')->nullable()->comment('zendesk ticket id.');
            $table->string('lodged_status')->nullable()->comment('zendesk ticket status: Open, Accepted, Declined');
            $table->boolean('accept_statement')->default(0)->comment('0: Not accepted, 1: Accepted');
            $table->boolean('privacy_statement')->default(0)->comment('0: Not accepted, 1: Accepted');
            $table->string('upload')->nullable();
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
        Schema::dropIfExists('tbl_master_env_representation');
    }
};
