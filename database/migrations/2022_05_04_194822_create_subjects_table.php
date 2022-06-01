<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubjectsTable extends Migration
{

    public function up()
    {
        Schema::create('subjects', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('level_id')->unsigned();
            $table->integer('season_year_id')->unsigned();
            $table->string('subject_name');
            $table->timestamps();
            $table->foreign('level_id')->references('id')->on('levels')->onDelete('cascade');
            $table->foreign('season_year_id')->references('id')->on('season_years')->onDelete('cascade');

        });
    }

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
