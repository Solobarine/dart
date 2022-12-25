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
          $table->bigIncrements('id');
          $table->string('first_name');
          $table->string('last_name');
          $table->string('email');
          $table->string('phone_no');
          $table->string('password');
          $table->string('country');
          $table->string('state');
          $table->string('city');
          $table->string('address');
          $table->string('date_of_birth');
          $table->string('sex');
          $table->string('account_no');
          $table->bigInteger('balance');
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
