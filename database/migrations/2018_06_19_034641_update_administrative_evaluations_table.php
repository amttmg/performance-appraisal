<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateAdministrativeEvaluationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('administrative_evaluation', function (Blueprint $table) {
            $table->string('remarks')->nullable()->change();
            $table->float('total')->after('remarks');
            $table->dropColumn(['score']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('administrative_evaluation', function (Blueprint $table) {
            $table->dropColumn(['total']);
            $table->float('score');
        });
    }
}
