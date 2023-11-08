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
        Schema::create('users', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('role_id');
            $table->unsignedBigInteger('company_id');
            // $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
            $table->string('name');
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('two_factor_code')->nullable();
            $table->dateTime('two_factor_expires_at')->nullable();
            $table->boolean('two_factor_status')->default(1)->comment('1->enable, 0->disable');
            $table->rememberToken();
            $table->enum('status', ['0', '1'])->default('1')->comment('0: inactive, 1: active');
            $table->string('ni_number')->nullable();
            $table->string('operator_number')->nullable();
            $table->string('pin_number')->nullable();
            $table->integer('is_officer')->default(0)->comment('0: No, 1: Yes');
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->boolean('deleted')->default(false);
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
        Schema::dropIfExists('users');
    }
};
