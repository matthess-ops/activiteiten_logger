<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Activityoptions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
     {
         Schema::create('activityoptions', function (Blueprint $table) {
             $table->bigIncrements('id');
             $table->timestamps();
             $table->json('currentSelections');
             $table->json('mainActivities');
             $table->json('subActivities');
             $table->json('scaledOptions');
             $table->json('fixedOptions');
             $table->json('experiments');
             $table->json('suggestions');


         });
     }

  




     /**
      * Reverse the migrations.
      *
      * @return void
      */
     public function down()
     {
         Schema::dropIfExists('activityoptions');
     }
}
