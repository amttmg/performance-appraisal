<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAppraiseeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appraisal_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->timestamps();
        });
        Schema::create('appraise', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('session_id')->unsigned();
            $table->integer('appraisal_of')->unsigned();
            $table->integer('appraisal_by')->unsigned();
            $table->integer('type_id')->unsigned();
            $table->boolean('is_completed')->nullable();
            $table->timestamps();

            $table->foreign('session_id')->references('id')->on('sessions')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('appraisal_of')->references('id')->on('users')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('appraisal_by')->references('id')->on('users')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('type_id')->references('id')->on('appraisal_types')
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
        Schema::dropIfExists('appraisee');
    }
}
