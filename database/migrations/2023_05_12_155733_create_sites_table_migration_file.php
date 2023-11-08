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
        Schema::create('sites', function (Blueprint $table) {
            $table->id();
            $table->string('user_id')->nullable();
            $table->string('name');
            $table->string('slug');
            $table->string('geographical_area_id');
            $table->string('address_line1');
            $table->string('address_line2')->nullable();
            $table->string('address_line3')->nullable();
            $table->string('address_line4')->nullable();
            $table->string('district')->nullable();
            $table->string('town');
            $table->string('postal_code');
            $table->string('county')->nullable();
            $table->string('country');
            $table->string('geo_color');
            $table->string('logo')->nullable();
            $table->string('region_id');
            $table->integer('notice_charge_amount_reduced')->default(0);
            $table->integer('notice_charge_days_reduced')->default(0);
            $table->integer('notice_charge_amount_full')->default(0);
            $table->integer('notice_charge_days_full')->default(0);
            $table->integer('default_extension_days')->default(0);
            $table->integer('gdpr_url_expiry_hours')->default(0);
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
        Schema::dropIfExists('sites');
    }
};
