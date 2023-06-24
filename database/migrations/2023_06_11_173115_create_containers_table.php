<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContainersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('containers', function (Blueprint $table) {
            $table->id('containerid');
            $table->unsignedBigInteger('controllerid');
            $table->foreign('controllerid')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('meetingid');
            $table->foreign('meetingid')->references('meetingid')->on('meetings')->onDelete('cascade');
            $table->string('name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('containers');
    }
}
