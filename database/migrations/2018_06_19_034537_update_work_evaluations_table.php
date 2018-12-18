<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateWorkEvaluationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('work_evaluation', function (Blueprint $table) {
            $table->float('efficiency')->after('user_id');
            $table->float('productivity')->after('efficiency');
            $table->string('remarks')->nullable()->change();
            $table->float('total')->after('productivity');
            $table->dropColumn(['planned_vs_spent_hours']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('work_evaluation', function (Blueprint $table) {
            $table->float('planned_vs_spent_hours');
            $table->dropColumn(['efficiency', 'productivity', 'total']);
        });
    }
}
