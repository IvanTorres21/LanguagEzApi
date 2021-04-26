<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserTestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_tests', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('users_id')->unsigned()->nullable();
            $table->bigInteger('tests_id')->unsigned()->nullable();
            $table->integer('score');
            $table->foreign('users_id')->references('id')->on('users')->onUpdate('set null')->onDelete('set null');
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
        Schema::dropIfExists('user_tests');
    }
}
