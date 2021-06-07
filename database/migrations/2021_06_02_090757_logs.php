<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Logs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
 
        public function up()
        {
            Schema::create('logs', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->timestamps();
                $table->timestamp('start')->nullable();
                $table->timestamp('end')->nullable();

                $table->json('log');
                
   
            });
        }
    

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('logs');

    }
}
