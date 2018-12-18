<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->increments('id');
            $table->string('project_code');
            $table->float('planned_vs_spent_hours')->nullable();
            $table->float('planned_vs_spent_beta_release')->nullable();
            $table->float('project_quality')->nullable();
            $table->float('project_complexity')->nullable();
            $table->float('bug_vs_planned')->nullable();
            $table->float('code_quality')->nullable();
            $table->float('total_score')->nullable();
            $table->boolean('is_completed');
            $table->string('department');
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
        Schema::dropIfExists('projects');
    }
}
