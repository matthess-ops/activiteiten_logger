<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TimerData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
     {
         Schema::create('timer_data', function (Blueprint $table) {
             $table->bigIncrements('id');
             $table->timestamps();
             $table->json('currentSelections');
             $table->json('mainActivities');
             $table->json('subActivities');
             $table->json('scaledOptions');
             $table->json('fixedOptions');
             $table->json('experiments');
             $table->json('suggestions');
             $table->json('previousLog');

             $table->boolean('timerRunning');


         });
     }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('timer_data');

    }
}
