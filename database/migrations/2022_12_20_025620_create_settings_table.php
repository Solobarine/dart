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
        Schema::create('settings', function (Blueprint $table) {
          $table->id();
          $table->string('account_no');
          $table->string('background_color_1')->default('#59bdbb');
          $table->string('background_color_2')->default('#fc9790');
          $table->string('background_color_3')->default('#f2f7f6');
          $table->string('background_color_4')->default('#ede');
          $table->string('background_color_5')->default('#fff');
          $table->string('color_1')->default('#427e7a');
          $table->string('color_2')->default('#ede');
          $table->string('color_3')->default('#000');
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
        Schema::dropIfExists('settings');
    }
};
