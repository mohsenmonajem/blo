<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Createtablesudentclass extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('studentclass', function (Blueprint $table) {

            $table->Integer('studentkey')->unsigned();
            $table->Integer('code_class')->unsigned();
            $table->foreign('studentkey')->references('studnetkey')->on('student')->onDelete('cascade');
            $table->foreign('code_class')->references('code_class')->on('teacher_request')->onDelete('cascade');
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
