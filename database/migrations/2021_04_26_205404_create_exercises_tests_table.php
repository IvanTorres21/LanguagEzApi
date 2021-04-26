<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExercisesTestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exercises_tests', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('tests_id')->unsigned()->nullable();
            $table->integer('type');
            $table->json('sentence')->nullable();
            $table->json('translation')->nullable();
            $table->json('og_word')->nullable();
            $table->json('correct_word')->nullable();
            $table->json('wrong_word')->nullable();
            $table->foreign('tests_id')->references('id')->on('tests')->onUpdate('set null')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('exercises_tests');
    }
}
