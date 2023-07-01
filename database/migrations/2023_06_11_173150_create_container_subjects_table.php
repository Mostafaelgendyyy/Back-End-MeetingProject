<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContainerSubjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('container_subjects', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('containerid');
            $table->foreign('containerid')->references('containerid')->on('containers')->onDelete('cascade');
            $table->unsignedBigInteger('subjectid');
            $table->foreign('subjectid')->references('subjectid')->on('subjects')->onDelete('cascade');
            $table->integer('votes-accepted');
            $table->integer('votes-rejected');
            $table->string('decision');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('container_subjects');
    }
}
