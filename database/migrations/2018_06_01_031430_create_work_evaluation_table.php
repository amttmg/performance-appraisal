<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWorkEvaluationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('work_evaluation', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('session_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->float('planned_vs_spent_hours');
            $table->string('remarks');
            $table->timestamps();

            $table->foreign('session_id')->references('id')->on('sessions')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('user_id')->references('id')->on('users')
                ->onUpdate('cascade')->onDelete('cascade');
        });

        Schema::create('administrative_evaluation', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('session_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->float('attendance');
            $table->float('punctuality');
            $table->float('score');
            $table->string('remarks');
            $table->timestamps();

            $table->foreign('session_id')->references('id')->on('sessions')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('user_id')->references('id')->on('users')
                ->onUpdate('cascade')->onDelete('cascade');
        });

        Schema::create('answers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('appraise_id')->unsigned();
            $table->integer('question_id')->unsigned();
            $table->float('rating');
            $table->string('feedback');
            $table->timestamps();

            $table->foreign('appraise_id')->references('id')->on('appraise')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('question_id')->references('id')->on('questions')
                ->onUpdate('cascade')->onDelete('cascade');

        });

        Schema::create('strength_vs_weakness', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('appraise_id')->unsigned();
            $table->string('strength')->nullable();
            $table->string('weakness')->nullable();
            $table->string('training_required')->nullable();
            $table->string('feedback')->nullable();
            $table->timestamps();

            $table->foreign('appraise_id')->references('id')->on('appraise')
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
        Schema::dropIfExists('work_evaluation');
    }
}
