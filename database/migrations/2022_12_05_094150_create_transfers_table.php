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
        Schema::create('transfers', function (Blueprint $table) {
          $table->bigIncrements('id');
          $table->bigInteger('amount');
          $table->string('transaction_id');
          $table->string('sender_first_name');
          $table->string('sender_last_name');
          $table->string('sender_account_no');
          $table->string('card_no');
          $table->string('receiver_first_name');
          $table->string('receiver_last_name');
          $table->string('receiver_account_no');
          $table->string('status');
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
        Schema::dropIfExists('transfers');
    }
};
