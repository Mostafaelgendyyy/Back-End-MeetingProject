<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subjects', function (Blueprint $table) {
            $table->id('subjectid');
            $table->unsignedBigInteger('controllerid')->nullable();
            $table->foreign('controllerid')->references('id')->on('users')->onDelete('cascade');
            $table->string('description');
            $table->string('subjecttype');
            $table->string('finaldecision')->nullable();
            $table->boolean('isCompleted');
            $table->string('from');
            $table->string('to')->nullable();
            $table->string('attachmentlink')->nullable();
            $table->timestamps();
        });
    }

    /*

     */
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subjects');
    }
}
