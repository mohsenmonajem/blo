<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Change extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
           

        });
        Schema::table('teacher', function (Blueprint $table) {
          
        });
        Schema::table('student', function (Blueprint $table) {
          
     //     $table->integer('userid')->unsigned();
          $table->foreign('userid')->references('userid')->on('users');

           
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
