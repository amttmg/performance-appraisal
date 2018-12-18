<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('question_groups', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->integer('parent_id')->nullable();
            $table->timestamps();
        });
        Schema::create('questions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('group_id')->unsigned();
            $table->text('question');
            $table->timestamps();

            $table->foreign('group_id')->references('id')->on('question_groups')
                ->onUpdate('cascade')->onDelete('cascade');
        });
        Schema::create('question_technology', function (Blueprint $table) {
            $table->integer('question_id')->unsigned();
            $table->integer('technology_id')->unsigned();
            $table->timestamps();

            $table->foreign('question_id')->references('id')->on('questions')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('technology_id')->references('id')->on('technologies')
                ->onUpdate('cascade')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('questions');
    }
}
