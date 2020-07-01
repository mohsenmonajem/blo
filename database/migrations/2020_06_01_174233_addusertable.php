<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Addusertable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id('userid')->primarykey();
            $table->string('name');
            $table->string('family');
            $table->string('username')->unique();
            $table->email('email');
            $table->string('password');
            $table->string("role");
            $table->rememberToken();	
            
        
        });
        Schema::table('teacher', function (Blueprint $table) {
            Schema::drop('name');
            Schema::drop('family');
            Schema::drop('email');
            Schema::drop('remeber_token');
            $table->id('user');
            $table->foreign('user')->references('userid')->on('user');

        });
        Schema::table('student', function (Blueprint $table) {
            Schema::drop('name');
            Schema::drop('family');
            Schema::drop('email');
            Schema::drop('remeber_token');
            $table->id('user');
           
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
